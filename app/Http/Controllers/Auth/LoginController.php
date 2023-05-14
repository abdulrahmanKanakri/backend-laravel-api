<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\User\IUserService;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(private IUserService $userService)
    {
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userService->getUserByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error($request->all(), 'The provided credentials are incorrect');
        }

        $data = [
            'user' => $user,
            'token' => $user->generateToken($request->userAgent())
        ];

        return ApiResponse::success($data, 'Successfully logged-in');
    }
}
