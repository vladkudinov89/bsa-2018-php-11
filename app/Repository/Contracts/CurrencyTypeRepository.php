<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\CurrencyType;

interface CurrencyTypeRepository
{
    public function add(CurrencyType $currencyType) : CurrencyType;

    public function getById(int $id) : CurrencyType;

    /**
     * @return CurrencyType[]
     */
    public function findAll();
}
