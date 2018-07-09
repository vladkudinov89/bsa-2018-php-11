<?php

namespace App\Request\Contracts;

interface AddCurrencyRequest
{
    public function getWalletId() : int;

    public function getCurrencyId() : int;

    public function getAmount() : float;
}