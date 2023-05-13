<?php

namespace App\Services\News;

use App\Entities\NewsEntity;

interface INewsService
{
    /**
     * @return array<int, NewsEntity>
     */
    public function fetchNewsList(string $keyword = "", int $page = 0): array;
}
