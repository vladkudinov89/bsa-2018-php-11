<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\ICurrency;

interface ICurrencyRepository
{
    public function add(ICurrency $model) : ICurrency;
    public function update(ICurrency $model) : ICurrency;
    public function getById(int $id) : ICurrency;
    public function find() : array;
}
