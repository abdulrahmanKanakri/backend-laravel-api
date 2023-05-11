<?php

namespace App\Services\News;

use App\Entities\NewsEntity;

interface INewsSource
{
    /**
     * @return array<int, NewsEntity>
     */
    public function fetchNewsList(string $keyword = "", int $page = 0): array;
}
