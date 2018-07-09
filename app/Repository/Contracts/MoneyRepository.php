<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Money;

interface MoneyRepository
{
    public function add(Money $money) : Money;
}
