<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Balance;
use App\Domain\ValueObject\User\TelegramId;

class User
{
    public function __construct(
        private TelegramId $telegramId,
        private Balance    $balance
    ){}

    public function getBalance(): Balance
    {
        return $this->balance;
    }

    public function getTelegramId(): TelegramId
    {
        return $this->telegramId;
    }
}