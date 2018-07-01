<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ITrade;
use App\Repository\Contracts\ICurrencyRepository;
use app\Repository\Contracts\IRateRepository;
use app\Repository\Contracts\ITradeRepository;
use App\Request\Contracts\ITradeRequest;

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
     * @return ITrade
     */
    public function addTrade(ITradeRequest $tradeRequest) : ITrade;

    /**
     * Изменяет статус сделки на "deleted".
     * В этот статус может переводить только владелец сделки.
     *
     * @param ITrade $trade
     * @return ITrade
     */
    public function deleteTrade(ITrade $trade) : ITrade;

    /**
     * Изменяет статус сделки на "completed".
     * В этот статус могут переводить все пользователи кроме владельца сделки.
     * При изменении статуса владелец сделки должен получить уведомление на e-mail.
     *
     * Драйвер на логирование почты уже настроен в этом репозитории.
     * Отправленные e-mail вы можете найти в /storage/logs/
     * Создавать отдельные view для e-mail не обязательно, можно отправлять обычнй текст.
     *
     * @param ITrade $trade
     * @return ITrade
     */
    public function completeTrade(ITrade $trade) : ITrade;

    /**
     * Возвращает самую выгодную сделку.
     * Выгодной будем считать сделку с максимальным количеством денежных единиц по самому низкому курсу.
     *
     * @return ITrade
     */
    public function getTheMostProfitableTrade() : ITrade;

    /**
     * Возвращает массив активных сделок в формате описанном в App\Response\Contracts\ITradeResponse
     *
     * @return <ITradeResponse>array
     */
    public function getTrades() : array;
}
