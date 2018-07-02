<?php

namespace App\Request\Contracts;

/**
 * Interface CurrencyTypeRequest
 * @package App\Request\Contracts
 *
 * A request of creation currency type
 */
interface CurrencyTypeRequest
{
    /**
     * Name of adding currency type
     *
     * @return string
     */
    public function getName() : string;
}