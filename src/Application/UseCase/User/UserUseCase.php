<?php

namespace App\Application\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\ValueObject\User\Balance;
use App\Domain\ValueObject\User\TelegramId;
use TelegramBot\Api\Exception;

class UserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function createUser(TelegramId $telegramId): User
    {
        $user = $this->userRepository->getByTelegramId($telegramId);
        if (is_null($user)) {
            $user = new User($telegramId, new Balance(0, 0));
            $this->userRepository->save($user);
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    public function updateUserBalance(TelegramId $telegramId, string $amount): string
    {
        $user = $this->userRepository->getByTelegramId($telegramId);

        [$dollar, $cent] = array_map('intval', explode('.', $amount));

        $balance = new Balance(abs($dollar), $cent);
        if ($dollar > 0) {
            $user->getBalance()->add($balance);
        } else {
            $user->getBalance()->subtract($balance);
        }

        $this->userRepository->save($user);

        $centForPrint = $balance->getCent() < 10 ? '0' . $balance->getCent() : $balance->getCent();

        return "Your current balance is \${$balance->getDollar()}.$centForPrint";
    }
}