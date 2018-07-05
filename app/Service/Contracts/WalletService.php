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
     * @param CreateWalletRequest $walletRequest
     * @return Wallet
     */
    public function addWallet(CreateWalletRequest $walletRequest) : Wallet;

    /**
     * Add currency to a wallet.
     *
     * @return Currency
     */
    public function addCurrency(CurrencyRequest $currencyRequest) : Currency;

    /**
     * Take currency from a wallet.
     *
     * @param CurrencyRequest $currencyRequest
     * @return Currency
     */
    public function takeCurrency(CurrencyRequest $currencyRequest) : Currency;
}