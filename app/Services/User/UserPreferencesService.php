<?php

namespace App\Services\User;

class UserPreferencesService implements IUserPreferencesService
{
    public function __construct(private ICurrentUserService $currentUserService)
    {
    }

    public function updatePreferredSources(array $sourcesIds): void
    {
        $this->currentUserService->user()->sources()->sync($sourcesIds);
    }

    public function updatePreferredCategories(array $categoriesIds): void
    {
        $this->currentUserService->user()->categories()->sync($categoriesIds);
    }

    public function updatePreferredAuthors(array $authorsIds): void
    {
        $this->currentUserService->user()->authors()->sync($authorsIds);
    }
}
