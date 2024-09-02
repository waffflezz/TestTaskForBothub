<?php

namespace App\Domain\ValueObject\User;

class TelegramId
{
    public function __construct(
        private int $telegramId
    ){}

    public function getValue(): int
    {
        return $this->telegramId;
    }
}