<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\ICurrentUserService;
use App\Utils\ApiResponse;

class UserController extends Controller
{
    public function __construct(private ICurrentUserService $currentUserService)
    {
    }

    public function me()
    {
        $data = ['user' => $this->currentUserService->userWithPreferences()];

        return ApiResponse::success($data, 'Successfully registered');
    }
}
