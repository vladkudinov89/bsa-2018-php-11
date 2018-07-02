<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\Currency;
use App\Entity\Contracts\Lot;
use App\Entity\Contracts\Trade;
use App\Repository\Contracts\LotRepository;
use App\Repository\Contracts\TradeRepository;
use App\Request\Contracts\AddLotRequest;
use App\Request\Contracts\BuyLotRequest;
use App\Response\Contracts\LotResponse;

/**
 * Interface MarketService
 * @package App\Service\Contracts
 *
 * A service of work with selling currency
 */
interface MarketService
{
    public function __construct(
        TradeRepository $tradeRepository,
        LotRepository $lotRepository,
        WalletService $walletService
    );

    /**
     * Sell currency
     *
     * @param AddLotRequest $lotRequest
     * @return Lot
     */
    public function addLot(AddLotRequest $lotRequest) : Lot;

    /**
     * Buy currency
     *
     * @param BuyLotRequest $lotRequest
     * @return Trade
     */
    public function buyLot(BuyLotRequest $lotRequest) : Trade;

    /**
     * Return list of lots
     *
     * @return LotResponse[]
     */
    public function getLotList() : array;
}
