<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CurrentUserService implements ICurrentUserService
{
    public function user(): User
    {
        return Auth::user();
    }
}
