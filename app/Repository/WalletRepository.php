<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:35
 */

namespace App\Repository;


use App\Entity\Wallet;

class WalletRepository implements Contracts\WalletRepository
{
    public function add(Wallet $wallet): Wallet
    {
       $wallet->save();
       return $wallet;
    }

    public function findByUser(int $userId): ?Wallet
    {
        return Wallet::where('user_id' , $userId)->first();
    }

}