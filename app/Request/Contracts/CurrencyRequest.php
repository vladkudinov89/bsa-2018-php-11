<?php

namespace App\Request\Contracts;

interface CurrencyRequest
{
    public function getWalletId() : int;

    public function getCurrencyTypeId() : int;

    public function getAmount() : float;
}