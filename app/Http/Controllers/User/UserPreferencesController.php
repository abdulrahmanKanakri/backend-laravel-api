<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePreferredAuthorsRequest;
use App\Http\Requests\User\UpdatePreferredCategoriesRequest;
use App\Http\Requests\User\UpdatePreferredSourcesRequest;
use App\Services\User\IUserPreferencesService;
use App\Utils\ApiResponse;

class UserPreferencesController extends Controller
{
    public function __construct(private IUserPreferencesService $userPreferencesService)
    {
    }

    public function updatePreferredSources(UpdatePreferredSourcesRequest $request)
    {
        $this->userPreferencesService->updatePreferredSources($request->sources_ids);

        return ApiResponse::successMessage("Successfully updated");
    }

    public function updatePreferredCategories(UpdatePreferredCategoriesRequest $request)
    {
        $this->userPreferencesService->updatePreferredCategories($request->categories_ids);

        return ApiResponse::successMessage("Successfully updated");
    }

    public function updatePreferredAuthors(UpdatePreferredAuthorsRequest $request)
    {
        $this->userPreferencesService->updatePreferredAuthors($request->authors_ids);

        return ApiResponse::successMessage("Successfully updated");
    }
}
