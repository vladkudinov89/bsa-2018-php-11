<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:34
 */

namespace App\Repository;


use App\Entity\Trade;

class TradeRepository implements Contracts\TradeRepository
{
    public function add(Trade $trade): Trade
    {
        $trade->push();
        return $trade;
    }

}