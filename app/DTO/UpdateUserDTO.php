<?php

namespace App\DTO;

class UpdateUserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $password
    ) {
    }
}
