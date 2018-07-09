<?php

namespace App\Entity\Contracts;

/**
 * Interface Wallet
 * @package App\Entity\Contracts
 *
 * A wallet of a user
 */
interface Wallet
{
    public function getId() : int;

    public function getUserId() : int;
}
