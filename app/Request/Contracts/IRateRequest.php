<?php

namespace App\Request\Contracts;

interface IRateRequest
{
    public function getCurrencyId() : int;
    public function getRate() : float;
    public function getTimestamp() : string;
}