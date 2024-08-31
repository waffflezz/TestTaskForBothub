<?php

namespace App\Presentation\Repository\User;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserRepositoryInterface;
use App\Domain\ValueObject\User\TelegramId;
use App\Domain\ValueObject\User\Id;
use App\Domain\ValueObject\User\Balance;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private PDO $db
    ){}

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (telegram_id, dollar, cent) VALUES (:telegram_id, :dollar, :cent) ON DUPLICATE KEY UPDATE dollar = :dollar, cent = :cent";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':telegram_id' => $user->getTelegramId()->getValue(),
            ':dollar' => $user->getBalance()->getDollar(),
            ':cent' => $user->getBalance()->getCent(),
        ]);
    }

    public function getByTelegramId(TelegramId $id): ?User
    {
        $sql = "SELECT * FROM users WHERE telegram_id = :telegram_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':telegram_id' => $id->getValue()]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                new TelegramId($data['telegram_id']),
                new Balance($data['dollar'], $data['cent'])
            );
        }

        return null;
    }
}