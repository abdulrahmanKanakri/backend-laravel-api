<?php

namespace App\Services\News;

use App\Entities\NewsEntity;

interface INewsService
{
    /**
     * @return array<int, NewsEntity>
     */
    public function fetchNewsList(array $filters): array;
}
