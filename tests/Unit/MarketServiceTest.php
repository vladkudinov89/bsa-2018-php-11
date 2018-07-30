<?php

namespace Tests\Unit;


use App\Entity\Currency;
use App\Entity\Lot;
use App\Entity\Money;
use App\Entity\Trade;
use App\Entity\Wallet;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Exceptions\MarketException\IncorrectPriceException;
use App\Exceptions\MarketException\IncorrectTimeCloseException;
use App\Mail\TradeCreated;
use App\Repository\CurrencyRepository;
use App\Repository\LotRepository;
use App\Repository\MoneyRepository;
use App\Repository\TradeRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Request\AddCurrencyRequest;
use App\Request\AddLotRequest;
use App\Request\BuyLotRequest;
use App\Response\Contracts\LotResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Service\Contracts\MarketService;
use App\User;

class MarketServiceTest extends TestCase
{
    private $lotRepository;
    private $currencyRepository;
    private $userRepository;
    private $walletRepository;
    private $moneyRepository;
    private $tradeRepository;
    private $currencyService;
    private $walletService;
    private $marketService;

    protected function setUp()
    {
        parent::setUp();
        $this->lotRepository = $this->createMock(LotRepository::class);
        $this->currencyRepository = $this->createMock(CurrencyRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->walletRepository = $this->createMock(WalletRepository::class);
        $this->moneyRepository = $this->createMock(MoneyRepository::class);
        $this->tradeRepository = $this->createMock(TradeRepository::class);


        $this->lotRepository->method('add')->will($this->returnArgument(0));
        $this->tradeRepository->method('add')->will($this->returnArgument(0));
        $this->currencyRepository->method('add')->will($this->returnArgument(0));
        $this->walletRepository->method('add')->will($this->returnArgument(0));
        $this->moneyRepository->method('save')->will($this->returnArgument(0));


        $this->currencyService = new \App\Service\CurrencyService($this->currencyRepository);

        $this->walletService = new \App\Service\WalletService($this->moneyRepository, $this->walletRepository);

        $this->marketService = new \App\Service\MarketService(
            $this->lotRepository,
            $this->currencyRepository,
            $this->userRepository,
            $this->walletRepository,
            $this->moneyRepository,
            $this->tradeRepository,
            $this->walletService
        );
    }


    public function testAddLot()
    {
        $user = factory(User::class)->make(['id' => 1]);
        $currency = factory(Currency::class)->make(['id' => 1]);

        $lotRequest = new AddLotRequest(
            $currency->id,
            $user->id,
            Carbon::now()->getTimestamp(),
            Carbon::tomorrow()->getTimestamp(),
            5
        );
        $this->lotRepository->method('findActiveAllLots')->willReturn(new Collection());

        $currencyId = $lotRequest->getCurrencyId();
        $sellerId = $lotRequest->getSellerId();
        $dateTimeOpen = $lotRequest->getDateTimeOpen();
        $dateTimeClose = $lotRequest->getDateTimeClose();
        $price = $lotRequest->getPrice();

        $lot = $this->marketService->addLot($lotRequest);

        $this->assertInstanceOf(Lot::class, $lot);
        $this->assertEquals($currencyId, $lot->currency_id);
        $this->assertEquals($sellerId, $lot->seller_id);
//        print_r($dateTimeOpen);
//        print_r($lot->date_time_open);
        $this->assertEquals($dateTimeOpen, $lot->date_time_open->getTimestamp());
        $this->assertEquals($dateTimeClose, $lot->date_time_close->getTimestamp());
        $this->assertEquals($price, $lot->price);
    }

    public function testBuyLot()
    {
        Mail::fake();


        $currency = factory(Currency::class)->make(['id' => 1]);
        $buyer = factory(User::class)->make(['id' => 1]);
        $seller = factory(User::class)->make(['id' => 2]);

        $buyerWallet = factory(Wallet::class)->make(['id' => 1, 'user' => $buyer->id]);

        $buyerMoney = factory(Money::class)->make([
            'id' => 1,
            'wallet_id' => $buyerWallet->id,
            'currency_id' => $currency->id,
            'amount' => 500
        ]);

        $sellerWallet = factory(Wallet::class)->make([
            'id' => 2,
            'user_id' => $seller->id
        ]);

        $sellerMoney = factory(Money::class)->make([
            'id' => 2,
            'wallet_id' => $sellerWallet->id,
            'currency_id' => $currency->id,
            'amount' => 1000
        ]);

        $lot = factory(Lot::class)->make([
            'id' => 10,
            'currency_id' => $currency->id,
            'seller_id' => $seller->id,
            'date_time_open' => Carbon::now(),
            'date_time_close' => Carbon::tomorrow(),
            'price' => 25
        ]);

        $buyLotRequest = new BuyLotRequest($buyer->id, $lot->id, $lot->price);

        $this->userRepository->method('getById')->willReturn($buyer);

        $this->lotRepository->method('getById')->willReturn($lot);
        $this->walletRepository->method('findByUser')->willReturn($buyerWallet);
        $this->lotRepository->method('findActiveLot')->willReturn($lot);
        $this->currencyRepository->method('getById')->willReturn($currency);
        $this->moneyRepository->method('findByWalletAndCurrency')->willReturn($sellerMoney);
        $trade = $this->marketService->buyLot($buyLotRequest);

        $this->assertEquals($buyLotRequest->getUserId(), $trade->user_id);
        $this->assertEquals($buyLotRequest->getLotId(), $trade->lot_id);
        $this->assertEquals($buyLotRequest->getAmount(), $trade->amount);
        $this->assertInstanceOf(Trade::class, $trade);

        Mail::assertSent(TradeCreated::class);
    }

    public function testGetLot()
    {
        $currency = factory(Currency::class)->make(['id' => 1]);
        $user = factory(User::class)->make(['id' => 1]);
        $wallet = factory(Wallet::class)->make([
            'id' => 1,
            'user_id' => $user->id
        ]);
        $money = factory(Money::class)->make([
            'id' => 1,
            'wallet_id' => $wallet->id,
            'currency_id' => $currency->id,
            'amount' => 1000
        ]);
        $lot = factory(Lot::class)->make([
            'id' => 1,
            'currency_id' => $currency->id,
            'seller_id' => $user->id,
            'date_time_open' => Carbon::now(),
            'date_time_close' => Carbon::tomorrow(),
            'price' => 150
        ]);

        $this->lotRepository->method('getById')->willReturn($lot);
        $this->currencyRepository->method('getById')->willReturn($currency);
        $this->userRepository->method('getById')->willReturn($user);
        $this->walletRepository->method('findByUser')->willReturn($wallet);
        $this->moneyRepository->method('findByWalletAndCurrency')->willReturn($money);

        $lotResponse = $this->marketService->getLot($lot->id);

        $this->assertEquals($lot->id, $lotResponse->getId());
        $this->assertEquals($user->name, $lotResponse->getUserName());
        $this->assertEquals($currency->name, $lotResponse->getCurrencyName());
        $this->assertEquals($lot->date_time_open->format('Y/m/d H:i:s'), $lotResponse->getDateTimeOpen());
        $this->assertEquals($lot->date_time_close->format('Y/m/d H:i:s'), $lotResponse->getDateTimeClose());
        $this->assertEquals($lot->price, $lotResponse->getPrice());
    }

    public function testGetLotList()
    {
        $currency = factory(Currency::class)->make(['id' => 1]);
        $user = factory(User::class)->make(['id' => 2]);
        $wallet = factory(Wallet::class)->make(['id' => 1, 'user' => $user->id]);

        $money = factory(Money::class)->make([
            'id' => 1,
            'wallet_id' => $wallet->id,
            'currency_id' => $currency->id,
            'amount' => 1000
        ]);
        $lot = factory(Lot::class)->make([
            'id' => 5,
            'currency_id' => $currency->id,
            'seller_id' => $user->id,
            'date_time_open' => Carbon::now(),
            'date_time_close' => Carbon::tomorrow(),
            'price' => 100
        ]);
        $this->lotRepository->method('getById')->willReturn($lot);
        $this->currencyRepository->method('getById')->willReturn($currency);
        $this->userRepository->method('getById')->willReturn($user);
        $this->walletRepository->method('findByUser')->willReturn($wallet);
        $this->moneyRepository->method('findByWalletAndCurrency')->willReturn($money);
        $this->lotRepository->method('findAll')->willReturn([$lot, $lot]);
        $lotList = $this->marketService->getLotList();
        foreach ($lotList as $lot) {
            $this->assertInstanceOf(LotResponse::class, $lot);
        }
    }

}