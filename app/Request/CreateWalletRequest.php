<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:42
 */

namespace App\Request;


use Illuminate\Foundation\Http\FormRequest;

class CreateWalletRequest extends FormRequest implements Contracts\CreateWalletRequest
{
    public function getUserId(): int
    {
        return request()->input('user_id');
    }

}