<?php

namespace App\Entity\Contracts;

/**
 * Interface ICurrency
 * @package App\Entity\Contracts
 *
 * Описывает запись справочника валют
 *
 * Необходимо создать миграцию и таблицу на основании этого описания,
 * и реализовать методы в соответствующей модели
 */
interface ICurrency
{
    /**
     * Идентификатор валюты
     *
     * @return int
     */
    public function getId() : int;

    /**
     * Имя валюты
     *
     * @return string
     */
    public function getName() : string;
}
