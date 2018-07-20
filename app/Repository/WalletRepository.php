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
        // TODO: Implement add() method.
    }

    public function findByUser(int $userId): ?Wallet
    {
        // TODO: Implement findByUser() method.
    }

}