<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;

interface INewsSource
{
    /**
     * @return array<int, NewsEntity>
     */
    public function fetchNewsList(array $filters): array;
}
