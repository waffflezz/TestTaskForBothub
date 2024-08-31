<?php

namespace App\Domain\ValueObject\User;

class Id
{
    public function __construct(
        private int $id
    ){}

    public function getValue(): int
    {
        return $this->id;
    }
}