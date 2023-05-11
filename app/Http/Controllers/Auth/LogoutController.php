<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\ICurrentUserService;
use App\Utils\ApiResponse;

class LogoutController extends Controller
{
    public function __construct(private ICurrentUserService $currentUserService)
    {
    }

    public function logout()
    {
        $user = $this->currentUserService->user();
        $user->deleteCurrentToken();

        return ApiResponse::successMessage('Successfully logged-out');
    }
}
