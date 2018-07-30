<?php

namespace Tests\Feature;

use App\Entity\Currency;
use App\Entity\Lot;
use App\Entity\Money;
use App\Entity\Wallet;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetLots()
    {
        $currency = factory(Currency::class)->create();
        $userWallet = factory(Wallet::class)->create();

        $userMoney = factory(Money::class)->create([
            'currency_id' => $currency->id,
            'wallet_id' => $userWallet->id
        ]);
//        dd(User::find($userWallet->user_id));
//        dd(Carbon::now()->getTimestamp());
        $response = $this->actingAs(User::find($userWallet->user_id))
            ->json('post', '/api/v1/lots',[
                'currency_id' => $currency->id,
                'date_time_open' => Carbon::now()->getTimestamp(),
                'date_time_close' => Carbon::tomorrow()->getTimestamp(),
                'price' => 1000
            ]);
        $response->assertStatus(201);
    }

    public function testBuyLot()
    {
        $currency = factory(Currency::class)->create();
        $buyer = factory(User::class)->create();
        $userWallet = factory(Wallet::class)->create();
//        dd($userWallet);
        $lot = factory(Lot::class)->create([
            'currency_id' => $currency->id,
            'seller_id' => $userWallet->user_id
        ]);
        $buyerWallet = factory(Wallet::class)->create();
        $buyerMoney = factory(Money::class)->create([
            'currency_id' => $currency->id,
            'wallet_id' => $buyer->id
        ]);

        $response = $this->actingAs(User::find($buyer->id))
            ->json('POST', '/api/v1/trades',[
                'lot_id' => $lot->id,
                'amount' => 1000
            ]);
        $response->assertStatus(201);
    }

}
