<?php

namespace App\Services\News;

use App\Services\Source\NewsSourcesFactory;

class NewsService implements INewsService
{
    public function __construct(private NewsSourcesFactory $newsSourcesFactory)
    {
    }

    public function fetchNewsList(string $keyword = "", int $page = 0): array
    {
        $newsSource = $this->newsSourcesFactory->create();
        return $newsSource->fetchNewsList($keyword, $page);
    }
}
