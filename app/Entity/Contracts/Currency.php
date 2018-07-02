<?php

namespace App\Entity\Contracts;

/**
 * Interface Currency
 * @package App\Entity\Contracts
 *
 * An amount of user currency
 */
interface Currency
{
    /**
     * An identifier
     *
     * @return int
     */
    public function getId() : int;

    /**
     * An identifier of a currency type
     *
     * @return string
     */
    public function getCurrencyTypeId() : int;

    /**
     * An identifier of a wallet
     *
     * @return int
     */
    public function getWalletId() : int;

    /**
     * An amount of currency
     *
     * @return float
     */
    public function getAmount() : float;
}
