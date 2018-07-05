<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\CurrencyType;
use App\Repository\Contracts\CurrencyTypeRepository;
use App\Request\Contracts\CurrencyTypeRequest;

/**
 * Interface CurrencyTypeService
 * @package App\Service\Contracts
 *
 * Service by working with currency type
 */
interface CurrencyTypeService
{
    public function __construct(CurrencyTypeRepository $currencyTypeRepository);

    /**
     * @param CurrencyTypeRequest $currencyTypeRequest
     * @return CurrencyType
     */
    public function addCurrencyType(CurrencyTypeRequest $currencyTypeRequest) : CurrencyType;
}
