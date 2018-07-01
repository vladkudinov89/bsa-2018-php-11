<?php

namespace App\Response\Contracts;

/**
 * Interface ITradeResponse
 * @package App\Response\Contracts
 *
 * Формат записи сделки
 */
interface ITradeResponse
{
    /**
     * Имя владельца сделки
     *
     * @return string
     */
    public function getUser() : string;

    /**
     * Имя валюты
     *
     * @return string
     */
    public function getCurrency() : string;

    /**
     * Количество продаваемых денежных единиц
     *
     * @return float
     */
    public function getAmount() : float;

    /**
     * Текущий курс валюты
     *
     * @return float
     */
    public function getRate() : float;

    /**
     * Цена сделки с учетом курса
     *
     * @return float
     */
    public function getTotalPrice() : float;
}