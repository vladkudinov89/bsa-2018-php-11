<?php

namespace app\Repository\Contracts;

use App\Entity\Contracts\IRate;

interface IRateRepository
{
    public function add(IRate $model) : IRate;
    public function update(IRate $model) : IRate;
    public function getById(int $id) : IRate;
    public function find() : array;
}