<?php

namespace App\Http\Controllers\User;

use App\DTO\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserSettingsRequest;
use App\Services\User\ICurrentUserService;
use App\Services\User\IUserService;
use App\Utils\ApiResponse;

class UserSettingsController extends Controller
{
    public function __construct(
        private IUserService $userService,
        private ICurrentUserService $currentUserService
    ) {
    }

    public function updateUserSettings(UpdateUserSettingsRequest $request)
    {
        $currentUser = $this->currentUserService->user();

        $userDTO = new UpdateUserDTO(
            $currentUser->id,
            $request->input('name'),
            $request->input('password')
        );

        $user = $this->userService->updateUser($userDTO);

        $data = [
            'user' => $user,
        ];

        return ApiResponse::success($data, 'Successfully updated');
    }
}
