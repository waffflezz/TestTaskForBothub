<?php

namespace App\Domain\ValueObject\User;

class Id
{
    public function __construct(
        private int $id
    ){}

    public function getId(): int
    {
        return $this->id;
    }
}