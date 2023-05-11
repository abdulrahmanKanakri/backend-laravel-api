<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->deleteTokens();

        return ApiResponse::successMessage('Successfully logged-out');
    }
}
