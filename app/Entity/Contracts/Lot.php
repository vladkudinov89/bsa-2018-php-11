<?php

namespace App\Entity\Contracts;

/**
 * Interface Lot
 * @package App\Entity\Contracts
 *
 * Currency that a user sells
 */
interface Lot
{
    /**
     * An identifier of a lot
     *
     * @return int
     */
    public function getId() : int;

    /**
     * An identifier of selling currency
     *
     * @return int
     */
    public function getCurrencyId() : int;

    /**
     * Timestamp of a start selling currency
     *
     * @return int
     */
    public function getDateTimeOpen() : int;

    /**
     * Timestamp of a end selling currency
     *
     * @return int
     */
    public function getDateTimeClose() : int;

    /**
     * An identifier of user who sells currency
     *
     * @return int
     */
    public function getSellerId() : int;

    /**
     * Price of currency that a seller sets
     *
     * @return float
     */
    public function getPrice() : float;
}