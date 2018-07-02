<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\Trade;
use App\Repository\Contracts\ICurrencyRepository;
use app\Repository\Contracts\IRateRepository;
use app\Repository\Contracts\ITradeRepository;
use App\Request\Contracts\ITradeRequest;
use App\Response\Contracts\ITradeResponse;

/**
 * Interface IMarketService
 * @package App\Service\Contracts
 *
 * Сервис по работе с рынком валют
 */
interface IMarketService
{
    public function __construct(
        ITradeRepository $tradeRepository,
        ICurrencyRepository $currencyRepository,
        IRateRepository $rateRepository,
        IMarketValidationService $validationService
    );

    /**
     * Добавляет новую сделку на рынок со статусом "active".
     *
     * @param ITradeRequest $tradeRequest
     * @return Trade
     */
    public function addTrade(ITradeRequest $tradeRequest) : Trade;

    /**
     * Изменяет статус сделки на "deleted".
     * В этот статус может переводить только владелец сделки.
     *
     * @param Trade $trade
     * @return Trade
     */
    public function deleteTrade(Trade $trade) : Trade;

    /**
     * Изменяет статус сделки на "completed".
     * В этот статус могут переводить все пользователи кроме владельца сделки.
     * При изменении статуса владелец сделки должен получить уведомление на e-mail.
     *
     * Драйвер на логирование почты уже настроен в этом репозитории.
     * Отправленные e-mail вы можете найти в /storage/logs/
     * Создавать отдельные view для e-mail не обязательно, можно отправлять обычнй текст.
     *
     * @param Trade $trade
     * @return Trade
     */
    public function completeTrade(Trade $trade) : Trade;

    /**
     * Возвращает самую выгодную сделку.
     * Выгодной будем считать сделку с максимальным количеством денежных единиц по самому низкому курсу.
     *
     * @return Trade
     */
    public function getTheMostProfitableTrade() : Trade;

    /**
     * Возвращает массив активных сделок в формате описанном в App\Response\Contracts\ITradeResponse
     *
     * @return ITradeResponse[]
     */
    public function getTrades() : array;
}
