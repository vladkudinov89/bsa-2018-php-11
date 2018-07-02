<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Trade;

interface TradeRepository
{
    public function add(Trade $trade) : Trade;
}