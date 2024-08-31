<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;
use App\Domain\ValueObject\User\TelegramId;

interface UserRepositoryInterface
{
    public function add(User $user): void;

    public function getByTelegramId(TelegramId $id): User;
}