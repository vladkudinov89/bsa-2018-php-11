<?php

namespace App\Entity\Contracts;

interface IRate
{
    public function getId() : int;
    public function getCurrencyId() : int;
    public function getRate() : float;
}
