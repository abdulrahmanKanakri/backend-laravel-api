<?php

namespace App\Services\User;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    public function createUser(UserDTO $userDTO): User
    {
        $user = new User();
        $user->name = $userDTO->name;
        $user->email = $userDTO->email;
        $user->password = Hash::make($userDTO->password);
        $user->save();

        return $user;
    }

    public function getUserById(string $id): User | null
    {
        return User::find($id);
    }

    public function getUserByEmail(string $email): User | null
    {
        return User::where('email', $email)->first();
    }
}
