<?php

namespace app\Repository\Contracts;

use App\Entity\Contracts\Wallet;

interface IRateRepository
{
    public function add(Wallet $model) : Wallet;
    public function update(Wallet $model) : Wallet;
    public function getById(int $id) : Wallet;
    public function find() : array;
}