<?php

namespace App\Entity\Contracts;

/**
 * Interface Trade
 * @package App\Entity\Contracts
 *
 * A completed trade
 */
interface Trade
{
    /**
     * An identifier of trade
     *
     * @return int
     */
    public function getId() : int;

    /**
     * An identifier of a bought lot
     *
     * @return int
     */
    public function getLotId() : int;

    /**
     * An identifier of a user who bought currency
     *
     * @return int
     */
    public function getUserId() : int;

    /**
     * An amount of bought currency
     *
     * @return float
     */
    public function getAmount() : float;
}
