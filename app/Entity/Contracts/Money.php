<?php

namespace App\Entity\Contracts;

/**
 * Interface Money
 * @package App\Entity\Contracts
 *
 * Money in the wallet
 */
interface Money
{
    public function getId() : int;

    public function getCurrencyId() : int;

    public function getWalletId() : int;

    public function getAmount() : float;
}
