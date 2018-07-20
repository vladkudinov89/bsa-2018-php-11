<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repository\Contracts\CurrencyRepository::class,
            \App\Repository\CurrencyRepository::class);
        $this->app->bind(\App\Repository\Contracts\LotRepository::class,
            \App\Repository\LotRepository::class);
        $this->app->bind(\App\Repository\Contracts\MoneyRepository::class,
            \App\Repository\MoneyRepository::class);
        $this->app->bind(\App\Repository\Contracts\TradeRepository::class,
            \App\Repository\TradeRepository::class);
        $this->app->bind(\App\Repository\Contracts\UserRepository::class,
            \App\Repository\UserRepository::class);
        $this->app->bind(\App\Repository\Contracts\WalletRepository::class,
            \App\Repository\WalletRepository::class);

        $this->app->bind(\App\Service\Contracts\CurrencyService::class,
            \App\Service\CurrencyService::class);
        $this->app->bind(\App\Service\Contracts\MarketService::class,
            \App\Service\MarketService::class);
        $this->app->bind(\App\Service\Contracts\WalletService::class,
            \App\Service\WalletService::class);
    }
}
