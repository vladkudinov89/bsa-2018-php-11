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


        $this->currencyRepository->method('add')->will($this->returnCallback(function ($arg) {
            return self::returnModelWithId($arg);
        }));

        $this->lotRepository->method('add')->will($this->returnCallback(function ($arg) {
            return self::returnModelWithId($arg);
        }));

        $this->walletRepository->method('add')->will($this->returnCallback(function ($arg) {
            return self::returnModelWithId($arg);
        }));
        $this->moneyRepository->method('save')->will($this->returnCallback(function ($arg) {
            return self::returnModelWithId($arg);
        }));
        $this->tradeRepository->method('add')->will($this->returnCallback(function ($arg) {
            return self::returnModelWithId($arg);
        }));


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
        $this->assertEquals($dateTimeOpen, $lot->date_time_open);
        $this->assertEquals($dateTimeClose, $lot->date_time_close);
        $this->assertEquals($price, $lot->price);
    }

    public function testBuyLot()
    {
        Mail::fake();

        $buyer = factory(User::class)->make(['id' => 1]);

        $seller = factory(User::class)->make(['id' => 2]);

        $currency = factory(Currency::class)->make(['id' => 1]);

        $buyerWallet = factory(Wallet::class)->make(['id' => 1,'user' => $buyer->id]);

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
            'amount' => 500
            ]);

        $lot = factory(Lot::class)->make([
            'id' => 1,
            'currency_id' => $currency->id,
            'seller_id' => $seller->id,
            'date_time_open' => Carbon::now(),
            'date_time_close' => Carbon::tomorrow(),
            'price' => 4
        ]);

        $buyLotRequest = new BuyLotRequest($buyer->id, $lot->id, '2');
//        dd($buyLotRequest);
        $trade = $this->marketService->buyLot($buyLotRequest);
        $this->assertInstanceOf(Trade::class, $trade);
        Mail::assertSent(TradeCreated::class);
    }

    private static function returnModelWithId(Model $model)
    {
        $model->id = random_int(1, 100);
        return $model;
    }
}