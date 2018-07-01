<?php

namespace App\Entity\Contracts;
/**
 * Interface IRate
 * @package App\Entity\Contracts
 *
 * Описывает запись курса валюты
 *
 * Необходимо создать миграцию и таблицу на основании этого описания,
 * и реализовать методы в соответствующей модели
 */
interface IRate
{
    /**
     * Идентификатор курса
     *
     * @return int
     */
    public function getId() : int;

    /**
     * Идентификатор валюты
     *
     * @return int
     */
    public function getCurrencyId() : int;

    /**
     * Значение курса
     *
     * @return float
     */
    public function getRate() : float;

    /**
     * Временная метка добавления нового курса
     *
     * @return int
     */
    public function getTimestamp() : int;
}
