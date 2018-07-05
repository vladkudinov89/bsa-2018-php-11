<?php

namespace App\Request\Contracts;

interface CurrencyTypeRequest
{
    public function getName() : string;
}