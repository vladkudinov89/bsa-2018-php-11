<?php

namespace app\Repository\Contracts;

use App\Entity\Contracts\Trade;

interface ITradeRepository
{
    public function add(Trade $model) : Trade;
    public function update(Trade $model) : Trade;
    public function getById(int $id) : Trade;
    public function find() : array;
}