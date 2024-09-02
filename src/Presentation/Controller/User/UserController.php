<?php

namespace App\Presentation\Controller\User;

use App\Application\UseCase\User\UserUseCase;
use App\Domain\ValueObject\User\TelegramId;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class UserController
{
    public function __construct(
        private UserUseCase $userUseCase
    ){}

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function createUser(BotApi|Client $bot, $chatId): void
    {
        $user = $this->userUseCase->createUser(new TelegramId((int) $chatId));

        $bot->sendMessage($chatId, "User with balance: {$user->getBalance()->print()}");
    }

    public function updateUserBalance(BotApi|Client $bot, $chatId, $amount): void
    {
        if (is_numeric(str_replace([',', '.'], '', $amount)) && preg_match('/([0-9]+[\.,0-9]*)/', $amount)) {
            try {
                $response = $this->userUseCase->updateUserBalance(new TelegramId((int) $chatId), $amount);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
            $bot->sendMessage($chatId, $response);
        } else {
            $bot->sendMessage($chatId, "Invalid amount");
        }
    }
}