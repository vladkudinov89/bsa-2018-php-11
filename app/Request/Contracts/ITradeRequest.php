<?php

namespace App\Request\Contracts;

interface ITradeRequest
{
    public function getUserId() : int;
    public function getCurrencyId() : int;
    public function getAmount() : float;
    public function getStatus() : string;
}