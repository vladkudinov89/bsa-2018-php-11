<?php

namespace App\Service;


use App\Entity\Money;
use App\Entity\Wallet;
use App\Repository\Contracts\MoneyRepository;
use App\Repository\Contracts\WalletRepository;
use App\Request\Contracts\CreateWalletRequest;
use App\Request\Contracts\MoneyRequest;

class WalletService implements Contracts\WalletService
{
    private $moneyRepository;
    private $walletRepository;

    public function __construct(MoneyRepository $moneyRepository , WalletRepository $walletRepository)
    {
        $this->moneyRepository = $moneyRepository;
        $this->walletRepository = $walletRepository;
    }

    public function addWallet(CreateWalletRequest $walletRequest): Wallet
    {
        $wallet = new Wallet();
        $wallet->user_id = $walletRequest->getUserId();
        return $this->walletRepository->add($wallet);

    }

    public function addMoney(MoneyRequest $moneyRequest): Money
    {
        $walletId = $moneyRequest->getWalletId();
        $amount = $moneyRequest->getAmount();
        $currencyId = $moneyRequest->getCurrencyId();

        $money = $this->moneyRepository->findByWalletAndCurrency($walletId , $currencyId);

        if($money === null){
            $money = new Money;
            $money->wallet_id = $walletId;
            $money->currency_id = $currencyId;
            $money->amount = $amount;
        } else {
            $money->amount += $amount;
        }

        return $this->moneyRepository->save($money);
    }

    public function takeMoney(MoneyRequest $moneyRequest): Money
    {
        $walletId = $moneyRequest->getWalletId();
        $amount = $moneyRequest->getAmount();
        $currencyId = $moneyRequest->getCurrencyId();

        $money = $this->moneyRepository->findByWalletAndCurrency($walletId , $currencyId);

        $money->amount -= $amount;

        return $this->moneyRepository->save($money);
    }

}