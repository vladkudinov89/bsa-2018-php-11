<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:35
 */

namespace App\Repository;


use App\User;

class UserRepository implements Contracts\UserRepository
{
    public function getById(int $id): ?User
    {
        return User::find($id)->first();
    }

}