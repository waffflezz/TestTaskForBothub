<?php

namespace App\Application\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserRepositoryInterface;

class UserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function createUser()
    {
        // TODO: Add user if he not in db, or return user if he in db
    }
}