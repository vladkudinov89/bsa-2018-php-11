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
    private $walletId;
    private $currencyId;
    private $amount;

    public function __construct(int $walletId, int $currencyId, float $amount)
    {
        $this->walletId = $walletId;
        $this->currencyId = $currencyId;
        $this->amount = $amount;
    }

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