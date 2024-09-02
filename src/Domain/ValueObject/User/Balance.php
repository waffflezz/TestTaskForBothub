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
        $this->assertPriceIsValid($dollar, $cent);
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

    /**
     * @throws Exception
     */
    private function assertPriceIsValid(int $dollar, int $cent): void
    {
        if ($dollar < 0) {
            throw new Exception('dollar must be greater than 0');
        }

        if ($cent > 99) {
            throw new Exception("Cent bigger than 99");
        }
    }

    public function add(Balance $other): void
    {
        $centSum = $this->cent + $other->cent;
        $newCent = $centSum % 100;
        $newDollar = $this->dollar + $other->dollar + intdiv($centSum, 100);

        $this->dollar = $newDollar;
        $this->cent = $newCent;
    }

    public function subtract(Balance $other): void
    {
        if ($this->dollar < $other->dollar) {
            throw new Exception("Balance can't be less than 0");
        }

        if ($this->dollar === $other->dollar && $this->cent < $other->cent) {
            throw new Exception("Balance can't be less than 0");
        }

        if ($this->cent < $other->cent) {
            $newCent = 100 - ($other->cent - $this->cent);
            $newDollar = $this->dollar - $other->dollar - 1;
        } else {
            $newCent = $this->cent - $other->cent;
            $newDollar = $this->dollar - $other->dollar;
        }

        $this->dollar = $newDollar;
        $this->cent = $newCent;
    }

    public function print(): string
    {
        $centForPrint = $this->cent < 10 ? '0' . $this->cent : $this->cent;
        return "\$$this->dollar.$centForPrint";
    }
}