<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error($request->all(), 'The provided credentials are incorrect.');
        }

        $data = [
            'user' => $user,
            'token' => $user->generateToken()
        ];

        return ApiResponse::success($data, 'Successfully logged-in');
    }
}
