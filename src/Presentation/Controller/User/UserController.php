<?php

namespace App\Presentation\Controller\User;

use App\Application\UseCase\User\UserUseCase;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use TelegramBot\Api\Exception;

class UserController
{
    public function __construct(
        private UserUseCase $userUseCase
    ){}

    public function createUser(BotApi|Client $bot, $chatId, $telegramId): void
    {
        $user = $this->userUseCase->createUser($telegramId);

        $bot->sendMessage($chatId, "User with balance: {$user->getBalance()->print()}");
    }

    public function updateUserBalance(BotApi|Client $bot, $chatId, $telegramId, $amount): void
    {
        if (is_numeric(str_replace([',', '.'], '', $amount)) && preg_match('/^\$?[0-9]+(\.[0-9][0-9])?$/', $amount)) {
            try {
                $response = $this->userUseCase->updateUserBalance($telegramId, $amount);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
            $bot->sendMessage($chatId, $response);
        } else {
            $bot->sendMessage($chatId, "Invalid amount");
        }
    }
}