<?php

namespace App\Repository;

use App\Entity\Currency;

class CurrencyRepository implements Contracts\CurrencyRepository
{
    public function add(Currency $currency) : Currency
    {

    }

    public function getById(int $id) : ?Currency
    {
        return Currency::find($id) ? Currency::find($id) : null;
    }

    public function getCurrencyByName(string $name) : ?Currency
    {

    }

    /**
     * @return Currency[]
     */
    public function findAll()
    {
        return Currency::all();
    }

}