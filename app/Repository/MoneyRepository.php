<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:34
 */

namespace App\Repository;


use App\Entity\Money;

class MoneyRepository implements Contracts\MoneyRepository
{
    public function save(Money $money): Money
    {
        $money->save();
        return $money;
    }

    public function findByWalletAndCurrency(int $walletId, int $currencyId): ?Money
    {
        return Money::where([
            'wallet_id' => $walletId,
            'currency_id' => $currencyId,
        ])->first();
    }

}