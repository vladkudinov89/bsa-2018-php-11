<?php

namespace app\Repository\Contracts;

use App\Entity\Contracts\ITrade;

interface ITradeRepository
{
    public function add(ITrade $model) : ITrade;
    public function update(ITrade $model) : ITrade;
    public function getById(int $id) : ITrade;
    public function find() : array;
}