<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Balance;

class User
{
    public function __construct(
        private Id      $id,
        private Balance $balance
    ){}

    public function getId(): Id
    {
        return $this->id;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }
}