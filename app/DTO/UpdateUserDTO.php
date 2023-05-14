<?php

namespace App\DTO;

class UpdateUserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $password
    ) {
    }
}
