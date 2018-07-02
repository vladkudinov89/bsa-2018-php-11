<?php

namespace App\Request\Contracts;

interface CurrencyRequest
{
    public function getWalletId() : int;

    public function getCurrencyId() : int;

    public function getAmount() : float;
}