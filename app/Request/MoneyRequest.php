<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.07.18
 * Time: 12:43
 */

namespace App\Request;


use Illuminate\Foundation\Http\FormRequest;

class MoneyRequest extends FormRequest implements Contracts\MoneyRequest
{
    public function getWalletId(): int
    {
        return request()->input('wallet_id');
    }

    public function getCurrencyId(): int
    {
        return request()->input('currency_id');
    }

    public function getAmount(): float
    {
        return request()->input('amount');
    }

}