<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\Currency;
use App\Request\Contracts\AddCurrencyRequest;

interface CurrencyService
{
    public function addCurrency(AddCurrencyRequest $currencyRequest) : Currency;
}
