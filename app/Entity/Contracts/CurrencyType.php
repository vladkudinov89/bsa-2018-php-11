<?php

namespace App\Entity\Contracts;

/**
 * Interface CurrencyType
 * @package App\Entity\Contracts
 *
 * A type of currency
 */
interface Currency
{
    /**
     * An identifier of currency
     *
     * @return int
     */
    public function getId() : int;

    /**
     * A name of currency
     *
     * @return string
     */
    public function getName() : string;
}
