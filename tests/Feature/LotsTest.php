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

    public function testGetLot()
    {
        $currency = factory(Currency::class)->create();
        $userWallet = factory(Wallet::class)->create();
        $userMoney = factory(Money::class)->create([
            'currency_id' => $currency->id,
            'wallet_id' => $userWallet->id
        ]);
        $lot = factory(Lot::class)->create([
            'currency_id' => $currency->id,
            'seller_id' => $userWallet->user_id
        ]);
//        dd($lot);
        $response = $this->json('GET', "/api/v1/lots/$lot->id");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'user_name',
                'currency_name',
                'amount',
                'date_time_open',
                'date_time_close',
                'price'
            ]);
    }

    public function getLotsTest()
    {
        $currency = factory(Currency::class , 10)->create();
        $userWallet = factory(Wallet::class , 10)->create();
        $userMoney = factory(Money::class , 10)->create([
            'currency_id' => $currency->id,
            'wallet_id' => $userWallet->id
        ]);
        $lot = factory(Lot::class , 10)->create([
            'currency_id' => $currency->id,
            'seller_id' => $userWallet->user_id
        ]);
        $response = $this->json('GET' , 'api/v1/lots');
        $response->assertStatus(200);
    }

}
