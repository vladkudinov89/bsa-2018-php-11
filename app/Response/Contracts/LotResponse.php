<?php

namespace App\Response\Contracts;

interface LotResponse
{
    public function getUserName() : string;

    public function getCurrencyName() : string;

    /**
     * Format: yyyy/mm/dd hh:mm:ss
     *
     * @return string
     */
    public function getDateTimeOpen() : string;

    /**
     * Format: yyyy/mm/dd hh:mm:ss
     *
     * @return string
     */
    public function getDateTimeClose() : string;

    /**
     * Format: 00,00
     *
     * @return string
     */
    public function getPrice() : string;
}