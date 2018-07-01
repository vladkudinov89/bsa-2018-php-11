<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ITrade;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\CurrencyDoesNotExistException;
use App\Exceptions\WrongTradeAmountException;
use App\Request\Contracts\ITradeRequest;

interface IMarketValidationService
{
    /**
     * Сделка может иметь количество денежных единиц больше нуля.
     * Сделку можно добавить только с существующей валютой.
     * Добавлять сделки могут только зарегистрированные пользователи.
     *
     * @param ITradeRequest $tradeRequest
     *
     * @throws WrongTradeAmountException
     * @throws CurrencyDoesNotExistException
     * @throws AccessDeniedException
     */
    public function validateAddingTrade(ITradeRequest $tradeRequest) : void;

    /**
     * Удалять сделку может только владелец сделки
     *
     * @param ITrade $trade
     *
     * @throws AccessDeniedException
     */
    public function validateDeletingTrade(ITrade $trade) : void;

    /**
     * Выполнять сделку может только владелец сделки
     *
     * @param ITrade $trade
     *
     * @throws AccessDeniedException
     */
    public function validateCompletingTrade(ITrade $trade) : void;
}