<?php

namespace App\Entity\Contracts;

/**
 * Interface Currency
 * @package App\Entity\Contracts
 *
 * Type of currency
 */
interface Currency
{
    public function getId() : int;

    public function getName() : string;
}
