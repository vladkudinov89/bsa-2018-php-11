<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\Lot;

interface LotRepository
{
    public function add(Lot $lot) : Lot;

    public function getById(int $id) : Lot;

    public function findAll();
}