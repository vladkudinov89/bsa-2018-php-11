<?php

namespace Tests\Browser;

use App\Entity\Currency;
use App\Entity\Money;
use App\Entity\Wallet;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddLotBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_form_is_present()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit('/market/lots/add')
                    ->assertPresent('form');
            }
        );
    }

    public function testAddLot()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $currency = factory(Currency::class)->create();
            $wallet = factory(Wallet::class)->create(['user_id' => $user->id]);
            factory(Money::class)->create([
                'wallet_id' => $wallet->id,
                'currency_id' => $currency->id,
                'amount' => 100
            ]);
            $browser->loginAs($user)
                ->visit('/market/lots/add')
                ->assertPathIs('/market/lots/add')
                ->type('currency_id', $currency->id)
                ->type('seller_id', $user->id)
                ->type('short_name', 'BiTCoIn')
                ->type('date_time_open', 1587040303)
                ->type('date_time_close', 1587090303)
                ->type('price', 666.99)
                ->press('Add')
                ->pause(1000)
                ->assertSee('Lot has been added successfully!');
        });
    }
}
