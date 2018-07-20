<?php

namespace App\Repository;

use App\Entity\Currency;

class CurrencyRepository implements Contracts\CurrencyRepository
{
    public function add(Currency $currency) : Currency
    {
        $currency->push();
        return $currency;
    }

    public function getById(int $id) : ?Currency
    {
        return Currency::find($id);
    }

    public function getCurrencyByName(string $name) : ?Currency
    {
        return Currency::where('name' , $name)->first();
    }

    /**
     * @return Currency[]
     */
    public function findAll()
    {
        return Currency::all();
    }

}