<?php

namespace App\Service\Contracts;

use App\Exceptions\NegativeRateException;
use App\Request\Contracts\IRateRequest;

interface ICurrencyValidationService
{
    /**
     * Курс не может быть отрицательным
     *
     * @param IRateRequest $rateRequest
     *
     * @throws NegativeRateException
     */
    public function validateChangingRate(IRateRequest $rateRequest) : void;
}