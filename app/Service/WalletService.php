<?php

namespace App\Service;


use App\Entity\{
    Money,
    Wallet
};
use App\Repository\Contracts\{
    MoneyRepository,
    WalletRepository
};
use App\Request\Contracts\{
    CreateWalletRequest,
    MoneyRequest
};


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
        $wallet = $this->walletRepository->findByUser($walletRequest->getUserId());
        if(!isset($wallet)){

            $wallet = new Wallet();
            $wallet->user_id = $walletRequest->getUserId();
        }

        return $this->walletRepository->add($wallet);

    }

    public function addMoney(MoneyRequest $moneyRequest): Money
    {
        $walletId = $moneyRequest->getWalletId();
        $amount = $moneyRequest->getAmount();
        $currencyId = $moneyRequest->getCurrencyId();

        $money = $this->moneyRepository->findByWalletAndCurrency($walletId , $currencyId);

        if(empty($money)){
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

        if($money->amount >= $amount){
            $money->amount -= $amount;
        }

        return $this->moneyRepository->save($money);
    }

}