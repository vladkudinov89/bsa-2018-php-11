<?php

namespace App\Repository;

use App\Entity\Lot;

class LotRepository implements Contracts\LotRepository
{
    public function add(Lot $lot): Lot
    {
        $lot->push();
        return $lot;
    }

    public function getById(int $id): ?Lot
    {
        return Lot::find($id);
    }

    public function findAll()
    {
        return Lot::all();
    }

    public function findActiveLot(int $userId): ?Lot
    {
        return Lot::where('seller_id',$userId)->active()->first();
    }

}