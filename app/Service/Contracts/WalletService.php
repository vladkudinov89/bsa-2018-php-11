<?php

namespace App\Service\Contracts;

use App\Entity\Contracts\Currency;
use App\Entity\Contracts\Wallet;
use App\Repository\Contracts\CurrencyRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\CurrencyRequest;

/**
 * Interface WalletService
 * @package App\Service\Contracts
 */
interface WalletService
{
    public function __construct(WalletRepository $walletRepository, CurrencyRepository $currencyRepository);

    /**
     * Add wallet to user.
     *
     * User cannot have more than one wallet.
     *
     * @param CreateWalletRequest $walletRequest
     * @return Wallet
     */
    public function addWallet(CreateWalletRequest $walletRequest) : Wallet;

    /**
     * Add currency to a wallet.
     *
     * User can have more than one record of an amount of currency in the wallet.
     *
     * @return Currency
     */
    public function addCurrency(CurrencyRequest $currencyRequest) : Currency;

    /**
     * Take currency from a wallet.
     *
     * Add a new record with a negative value of the amount of currency.
     * Cannot be taken more an amount of currency than the wallet contains.
     *
     * @param CurrencyRequest $currencyRequest
     * @return Currency
     */
    public function takeCurrency(CurrencyRequest $currencyRequest) : Currency;
}