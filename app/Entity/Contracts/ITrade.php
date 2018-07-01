<?php

namespace App\Entity\Contracts;

/**
 * Interface ITrade
 * @package App\Entity\Contracts
 *
 * Описывает сделку
 *
 * Необходимо создать миграцию и таблицу на основании этого описания,
 * и реализовать методы в соответствующей модели
 */
interface ITrade
{
    /**
     * Идентификатор сделки
     *
     * @return int
     */
    public function getId() : int;

    /**
     * Идентификатор пользователя
     *
     * @return int
     */
    public function getUserId() : int;

    /**
     * Идентификатор модели
     *
     * @return int
     */
    public function getCurrencyId() : int;

    /**
     * Количество, продаваемых деенжных единиц
     *
     * @return float
     */
    public function getAmount() : float;

    /**
     * Статус может иметь одно из следующих значений:
     * "active", "deleted", "completed"
     *
     * @return string
     */
    public function getStatus() : string;
}
