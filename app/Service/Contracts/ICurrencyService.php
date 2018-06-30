<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ICurrency;

interface ICurrencyService
{
    function getRiseOfRate(ICurrency $currency) : float;
    function getTheMostExpensiveCurrency() : ICurrency;
}
