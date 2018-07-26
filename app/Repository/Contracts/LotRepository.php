<?php

namespace App\Repository\Contracts;

use App\Entity\Lot;
use Illuminate\Database\Eloquent\Collection;

interface LotRepository
{
    public function add(Lot $lot): Lot;

    public function getById(int $id): ?Lot;

    /**
     * @return Lot[]
     */
    public function findAll();

    public function findActiveAllLots(int $userId): Collection;

    public function findActiveLot(int $userId): ?Lot;
}