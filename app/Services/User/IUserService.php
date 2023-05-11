<?php

namespace App\Services\User;

use App\DTO\UserDTO;
use App\Models\User;

interface IUserService
{
    public function createUser(UserDTO $userDTO): User;
    public function getUserById(string $id): User | null;
    public function getUserByEmail(string $email): User | null;
}
