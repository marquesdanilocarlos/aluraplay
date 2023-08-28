<?php

namespace Aluraplay\Entity;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $password
    ) {
    }
}