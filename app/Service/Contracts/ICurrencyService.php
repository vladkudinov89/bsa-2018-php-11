<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ICurrency;

interface ICurrencyService
{
    function getRiseOfRate(ICurrency $currency) : array;
    function getTheMostExpensiveCurrency() : ICurrency;
}
