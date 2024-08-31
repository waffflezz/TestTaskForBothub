<?php

namespace App\Presentation\Repository\User;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\ValueObject\User\TelegramId;

class UserRepository implements UserRepositoryInterface
{

    public function add(User $user): void
    {
        // TODO: Implement add() method.
    }

    public function getByTelegramId(TelegramId $id): User
    {
        // TODO: Implement getById() method.
    }
}