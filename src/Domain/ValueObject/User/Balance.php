<?php

namespace App\Domain\ValueObject\User;

use TelegramBot\Api\Exception;

final class Balance
{
    /**
     * @throws Exception
     */
    public function __construct(
        private int $dollar, // before . or , separator
        private int $cent // after . or , separator
    )
    {
        $this->assertPriceIsValid($cent);
    }

    public function getDollar(): int
    {
        return $this->dollar;
    }

    public function getCent(): int
    {
        return $this->cent;
    }

    public function getFullPrice(): array
    {
        return ['dollar' => $this->dollar, 'cent' => $this->cent];
    }

    private function assertPriceIsValid(int $cent): void
    {
        if ($cent > 99) {
            throw new Exception("Cent bigger than 99");
        }
    }
}