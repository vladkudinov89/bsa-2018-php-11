<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Currency;

interface ICurrencyRepository
{
    public function add(Currency $model) : Currency;
    public function update(Currency $model) : Currency;
    public function getById(int $id) : Currency;
    public function find() : array;
}
