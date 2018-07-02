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
    /**
     * An identifier of a wallet
     *
     * @return int
     */
    public function getId() : int;

    /**
     * An identifier of a user
     *
     * @return int
     */
    public function getUserId() : int;
}
