<?php

namespace App\Entity\Contracts;

interface ICurrency
{
    public function getId() : int;
    public function getName() : string;
}
