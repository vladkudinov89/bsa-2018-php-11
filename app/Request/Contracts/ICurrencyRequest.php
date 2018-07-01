<?php

namespace App\Request\Contracts;

interface ICurrencyRequest
{
    public function getName() : string;
}