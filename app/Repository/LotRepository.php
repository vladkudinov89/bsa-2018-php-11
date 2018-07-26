<?php

namespace App\Repository;

use App\Entity\Lot;
use Carbon\Carbon;

class LotRepository implements Contracts\LotRepository
{
    public function add(Lot $lot): Lot
    {
        $lot->save();
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
        return Lot::where('seller_id', $userId)
                ->whereDate('date_time_open', '>=', Carbon::now())
                ->whereDate('date_time_close', '<', Carbon::now())->first();
    }

}