<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ITrade;

interface IMarketService
{
    public function getTheMostExpensiveTrade() : ITrade;
}
