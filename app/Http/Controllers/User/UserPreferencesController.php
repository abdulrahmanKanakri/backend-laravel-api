<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdatePreferredAuthorsRequest;
use App\Http\Requests\User\UpdatePreferredCategoriesRequest;
use App\Http\Requests\User\UpdatePreferredSourcesRequest;
use App\Services\User\IUserPreferencesService;

class UserPreferencesController extends Controller
{
    public function __construct(private IUserPreferencesService $userPreferencesService)
    {
    }

    public function updatePreferredSources(UpdatePreferredSourcesRequest $request)
    {
        $this->userPreferencesService->updatePreferredSources($request->sources_ids);
    }

    public function updatePreferredCategories(UpdatePreferredCategoriesRequest $request)
    {
        $this->userPreferencesService->updatePreferredCategories($request->categories_ids);
    }

    public function updatePreferredAuthors(UpdatePreferredAuthorsRequest $request)
    {
        $this->userPreferencesService->updatePreferredAuthors($request->authors_ids);
    }
}
