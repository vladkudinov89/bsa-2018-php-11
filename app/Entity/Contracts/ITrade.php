<?php

namespace App\Entity\Contracts;

interface ITrade
{
    public function getId() : int;
    public function getUserId() : int;
    public function getCurrencyId() : int;
    public function getAmount() : float;
    /**
     * @return string   "active" | "completed" | "deleted"
     */
    public function getStatus() : string;
}
