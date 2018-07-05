<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Trade;

interface TradeRepository
{
    public function add(Trade $trade) : Trade;

    public function getById(int $id) : Trade;

    /**
     * @return Trade[]
     */
    public function findAll();
}