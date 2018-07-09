<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Wallet;

interface WalletRepository
{
    public function add(Wallet $wallet) : Wallet;
}