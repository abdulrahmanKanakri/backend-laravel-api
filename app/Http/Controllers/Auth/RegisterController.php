<?php

namespace App\Http\Controllers\Auth;

use App\DTO\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\User\IUserService;
use App\Utils\ApiResponse;

class RegisterController extends Controller
{
    public function __construct(private IUserService $userService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $userDTO = new CreateUserDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $user = $this->userService->createUser($userDTO);

        $data = [
            'user' => $user,
            'token' => $user->generateToken($request->userAgent())
        ];

        return ApiResponse::success($data, 'Successfully registered');
    }
}
