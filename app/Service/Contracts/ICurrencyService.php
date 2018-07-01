<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\ICurrency;
use App\Entity\Contracts\IRate;
use App\Repository\Contracts\ICurrencyRepository;
use app\Repository\Contracts\IRateRepository;
use App\Request\Contracts\ICurrencyRequest;
use App\Request\Contracts\IRateRequest;

/**
 * Interface ICurrencyService
 * @package App\Service\Contracts
 *
 * Сервис по работе с валютами
 *
 */
interface ICurrencyService
{
    public function __construct(
        ICurrencyRepository $currencyRepository,
        IRateRepository $rateRepository,
        ICurrencyValidationService $validationService
    );

    /**
     * Добавляет валюту в справочник
     *
     * @param ICurrencyRequest $currencyRequest
     * @return ICurrency
     */
    public function addCurrency(ICurrencyRequest $currencyRequest) : ICurrency;

    /**
     * Изменяет курс валюты.
     * Должна добавляться новая запись в таблицу курса валют.
     * При изменении курса валюты все пользователи с активными сделками с этой валютой должны быть проинформированы по e-mail.
     *
     * Драйвер на логирование почты уже настроен в этом репозитории.
     * Отправленные e-mail вы можете найти в /storage/logs/
     * Создавать отдельные view для e-mail не обязательно, можно отправлять обычнй текст.
     *
     * @param IRateRequest $rateRequest
     * @return IRate
     */
    public function changeRate(IRateRequest $rateRequest) : IRate;
}
