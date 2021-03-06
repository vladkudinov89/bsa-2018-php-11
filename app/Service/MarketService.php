<?php

namespace App\Service;

use App\Entity\Lot;
use App\Entity\Trade;
use App\Mail\TradeCreated;
use App\Exceptions\MarketException\{
    LotDoesNotExistException,
    ActiveLotExistsException,
    IncorrectTimeCloseException,
    IncorrectPriceException,
    BuyNegativeAmountException,
    IncorrectLotAmountException,
    BuyOwnCurrencyException,
    BuyInactiveLotException
};
use App\Repository\Contracts\{
    CurrencyRepository,
    LotRepository,
    MoneyRepository,
    TradeRepository,
    UserRepository,
    WalletRepository
};
use App\Request\Contracts\{
    AddLotRequest,
    BuyLotRequest
};
use App\Request\MoneyRequest;
use App\Response\Contracts\LotResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MarketService implements Contracts\MarketService
{

    private $lotRepository;
    private $currencyRepository;
    private $userRepository;
    private $walletRepository;
    private $moneyRepository;
    private $tradeRepository;
    private $walletService;

    public function __construct(
        LotRepository $lotRepository,
        CurrencyRepository $currencyRepository,
        UserRepository $userRepository,
        WalletRepository $walletRepository,
        MoneyRepository $moneyRepository,
        TradeRepository $tradeRepository,
        \App\Service\Contracts\WalletService $walletService)
    {
        $this->lotRepository = $lotRepository;
        $this->currencyRepository = $currencyRepository;
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
        $this->moneyRepository = $moneyRepository;
        $this->tradeRepository = $tradeRepository;
        $this->walletService = $walletService;
    }

    public function addLot(AddLotRequest $lotRequest): Lot
    {
        $lots = $this->lotRepository->findActiveAllLots($lotRequest->getSellerId());

        foreach ($lots as $lot) {
            if ($lot->currency_id == $lotRequest->getCurrencyId()) {
                throw new ActiveLotExistsException("User already has active currency lot");
            }
        }

        if ($lotRequest->getDateTimeClose() <= $lotRequest->getDateTimeOpen()) {
            throw new IncorrectTimeCloseException("Close datetime can't be before open");
        }

        if ($lotRequest->getPrice() < 0) {
            throw new IncorrectPriceException("Price must be positive");
        }

        $lot = new Lot;
        $lot->currency_id = $lotRequest->getCurrencyId();
        $lot->seller_id = $lotRequest->getSellerId();
        $lot->price = $lotRequest->getPrice();
        $lot->date_time_open = Carbon::createFromTimestamp($lotRequest->getDateTimeOpen());
        $lot->date_time_close = Carbon::createFromTimestamp($lotRequest->getDateTimeClose());

        return $this->lotRepository->add($lot);
    }

    public function buyLot(BuyLotRequest $lotRequest): Trade
    {
        $amount = $lotRequest->getAmount();
        $lotId = $lotRequest->getLotId();
        $userId = $lotRequest->getUserId();

        $lot = $this->lotRepository->getById($lotId);
        $buyer = $this->userRepository->getById($userId);
        $seller = $this->userRepository->getById($lot->seller_id);
        $sellerWallet = $this->walletRepository->findByUser($lot->seller_id);
        $sellerMoney = $this->moneyRepository->findByWalletAndCurrency($sellerWallet->id, $lot->currency_id);

        if ($lot === null) {
            throw new LotDoesNotExistException("Lot with id:$lot doesn't exist");
        }

        if ($amount < 0) {
            throw new BuyNegativeAmountException("Amount must be positive");
        }

        if ($amount < 1) {
            throw new IncorrectLotAmountException("User can not buy less than one currency unit");
        }

        if ($lot->seller_id == $buyer->id) {
            throw new BuyOwnCurrencyException("User can't buy own currency");
        }

        if (
            $lot->getDateTimeOpen() > Carbon::now()->getTimestamp()
            ||
            $lot->getDateTimeClose() <= Carbon::now()->getTimestamp()
        ) {
            throw new BuyInactiveLotException("Lot $lot->id isn't active");
        }

        if ($amount > $sellerMoney->amount) {
            throw new IncorrectLotAmountException("Not enough money in lot for this operation");
        }

        $this->walletService->takeMoney(
            new MoneyRequest(
                $buyer->id,
                $lot->currency_id,
                $amount
            )
        );

        $this->walletService->addMoney(
            new MoneyRequest(
                $sellerWallet->id,
                $lot->currency_id,
                $amount
            )
        );

        $trade = new Trade;
        $trade->lot_id = $lotRequest->getLotId();
        $trade->user_id = $lotRequest->getUserId();
        $trade->amount = $lotRequest->getAmount();


        $mailMessage = new TradeCreated($trade, $seller, $buyer, $this->currencyRepository->getById($lot->id));
        Mail::send($mailMessage);

        return $this->tradeRepository->add($trade);

    }

    public function getLot(int $id): LotResponse
    {
        $lot = $this->lotRepository->getById($id);
        $currency = $this->currencyRepository->getById($lot->currency_id);
        $user = $this->userRepository->getById($lot->seller_id);
        $wallet = $this->walletRepository->findByUser($user->id);
        $money = $this->moneyRepository->findByWalletAndCurrency($wallet->id, $currency->id);

        return $response = new \App\Response\LotResponse(
            $lot->id,
            $user->name,
            $currency->name,
            $money->amount,
            $lot->getDateTimeOpen(),
            $lot->getDateTimeClose(),
            $lot->price
        );
    }

    public function getLotList(): array
    {
        $arrayLot = [];
        $lots = $this->lotRepository->findAll();
        foreach ($lots as $lot) {
            $arrayLot[] = $this->getLot($lot->id);
        }
        return $arrayLot;
    }

}