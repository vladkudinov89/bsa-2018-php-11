<?php

namespace Tests\Unit;


use App\Entity\Lot;
use App\Exceptions\MarketException\ActiveLotExistsException;
use App\Exceptions\MarketException\IncorrectPriceException;
use App\Exceptions\MarketException\IncorrectTimeCloseException;
use App\Repository\CurrencyRepository;
use App\Repository\LotRepository;
use App\Repository\MoneyRepository;
use App\Repository\TradeRepository;
use App\Repository\UserRepository;
use App\Repository\WalletRepository;
use App\Request\AddCurrencyRequest;
use App\Request\AddLotRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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

    public function testInstance()
    {
        $this->assertInstanceOf(
            MarketService::class,
            $this->marketService
        );
    }


    public function testAddLot()
    {
        $user = self::user();
        $currencyName = self::currencyName();

        $addCurrencyRequest = new AddCurrencyRequest($currencyName);
        $currency = $this->currencyService->addCurrency($addCurrencyRequest);

        $lotRequest = new AddLotRequest(
            $currency->id,
            $user->id,
            Carbon::now()->getTimestamp(),
            Carbon::tomorrow()->getTimestamp(),
            5
        );
        $this->lotRepository->method('findActiveAllLots')->willReturn(new Collection());
        $lots = $this->lotRepository->findActiveAllLots($lotRequest->getSellerId());

        $currencyId = $lotRequest->getCurrencyId();
        $sellerId = $lotRequest->getSellerId();
        $dateTimeOpen = $lotRequest->getDateTimeOpen();
        $dateTimeClose = $lotRequest->getDateTimeClose();
        $price = $lotRequest->getPrice();

        foreach ($lots as $lot) {
            try {
                $this->assertEquals($lot->currency_id, $currencyId);
            } catch (ActiveLotExistsException $e) {
                throw new ActiveLotExistsException("User already has active currency lot");
            }
        }

        try {
            $this->assertGreaterThanOrEqual($lotRequest->getDateTimeOpen(), $lotRequest->getDateTimeClose());
        } catch (ActiveLotExistsException $e) {
            throw new IncorrectTimeCloseException("Close datetime can't be before open");
        }

        try {
            $this->assertGreaterThan(0, $price);
        } catch (ActiveLotExistsException $e) {
            throw new IncorrectPriceException("Price must be positive");
        }

        $lot = $this->marketService->addLot($lotRequest);

        $this->assertInstanceOf(Lot::class, $lot);
        $this->assertEquals($currencyId, $lot->currency_id);
        $this->assertEquals($sellerId, $lot->seller_id);
        $this->assertEquals($dateTimeOpen, $lot->date_time_open);
        $this->assertEquals($dateTimeClose, $lot->date_time_close);
        $this->assertEquals($price, $lot->price);
    }

    private static function returnModelWithId(Model $model)
    {
        $model->id = random_int(1, 100);
        return $model;
    }

    private static function user(): User
    {
        return new User([
            'id' => 1,
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret,
        ]);
    }

    private static function currencyName(): string
    {
        return "Bitcoin";
    }
}