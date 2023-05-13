<?php

namespace App\Services\User;

interface IUserPreferencesService
{
    /**
     * @param array<int, int> $sourcesIds
     */
    public function updatePreferredSources(array $sourcesIds): void;

    /**
     * @param array<int, int> $categoriesIds
     */
    public function updatePreferredCategories(array $categoriesIds): void;

    /**
     * @param array<int, int> $authorsIds
     */
    public function updatePreferredAuthors(array $authorsIds): void;
}
