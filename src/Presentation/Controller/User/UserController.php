<?php

namespace App\Presentation\Controller\User;

use App\Application\UseCase\User\UserUseCase;

class UserController
{
    public function __construct(
        private UserUseCase $userUseCase
    ){}

    public function createUser()
    {
        $user = $this->userUseCase->createUser();

        //
    }
}