<?php

namespace App\Services\User;

use App\DTO\CreateUserDTO;
use App\DTO\UpdateUserDTO;
use App\Models\User;

interface IUserService
{
    public function createUser(CreateUserDTO $userDTO): User;
    public function updateUser(UpdateUserDTO $userDTO): User;
    public function getUserById(string $id): User | null;
    public function getUserByEmail(string $email): User | null;
}
