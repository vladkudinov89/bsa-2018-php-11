<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(\App\Entity\Lot::class, function (Faker $faker) {
    return [
        'currency_id' => function () {
            return factory(App\Entity\Currency::class)->create()->id;
        },
        'seller_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'date_time_open' => Carbon::createFromTimestamp((int) time()),
        'date_time_close' => Carbon::createFromTimestamp((int) time() + 3600 * 60),
//        'date_time_open' => Carbon::now()->format('Y/m/d H:i:s'),
//        'date_time_close' => Carbon::tomorrow()->format('Y/m/d H:i:s'),
        'price' => $faker->randomFloat(2, 0, 1000),
    ];
});
