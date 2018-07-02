<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Currency;

interface CurrencyRepository
{
    public function add(Currency $currency) : Currency;
}