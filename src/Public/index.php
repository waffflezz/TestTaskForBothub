<?php

use App\Application\UseCase\User\UserUseCase;
use App\Domain\Entity\User;
use App\Domain\ValueObject\User\Balance;
use App\Domain\ValueObject\User\TelegramId;
use App\Presentation\Controller\User\UserController;
use App\Presentation\Repository\User\UserRepository;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;

require_once '../../vendor/autoload.php';

$pdo = new PDO('mysql:host=db;dbname=telegram_bot', 'root', 'password');
$userRepository = new UserRepository($pdo);
$userUseCase = new UserUseCase($userRepository);
$userController = new UserController($userUseCase);

$bot = new Client(getenv('TELEGRAM_BOT_TOKEN'));

$bot->on(function (Update $update) use ($bot, $userController) {
    $message = $update->getMessage();
    $chatId = $message->getChat()->getId();
    $amount = $message->getText();


    $userController->createUser($bot, $chatId);
    $userController->updateUserBalance($bot, $chatId, $amount);
}, function () {
    return true;
});

if(!empty($bot->getRawBody())){
    $bot->run();
}