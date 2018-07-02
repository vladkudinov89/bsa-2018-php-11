<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\CurrencyType;

/**
 * Interface CurrencyTypeRepository
 * @package App\Repository\Contracts
 *
 * Repository of currencies types
 */
interface CurrencyTypeRepository
{
    /**
     * Add currency type in a table currency_type
     *
     * @param CurrencyType $currencyType
     * @return CurrencyType
     */
    public function add(CurrencyType $currencyType) : CurrencyType;
}
