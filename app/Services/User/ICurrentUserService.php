<?php

namespace App\Services\User;

use App\Models\User;

interface ICurrentUserService
{
    public function user(): User;
}
