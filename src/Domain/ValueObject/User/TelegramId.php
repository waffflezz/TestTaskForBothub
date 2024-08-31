<?php

namespace App\Domain\ValueObject\User;

class TelegramId
{
    public function __construct(
        private string $telegramId
    ){}

    public function getTelegramId(): string
    {
        return $this->telegramId;
    }
}