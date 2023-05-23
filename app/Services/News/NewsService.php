<?php

namespace App\Services\News;

use App\Enums\Sources;
use App\Services\Source\INewsSource;
use App\Services\Source\NewsSourcesFactory;

class NewsService implements INewsService
{
    public function __construct(private NewsSourcesFactory $newsSourcesFactory)
    {
    }

    public function fetchNewsList(array $filters): array
    {
        $newsSource = $this->getNewsSource($filters["source"] ?? '');
        return $newsSource->fetchNewsList($filters);
    }

    private function getNewsSource(string $filteredSource): INewsSource
    {
        if (Sources::isValidValue($filteredSource)) {
            return $this->newsSourcesFactory->createFromList([$filteredSource]);
        }
        return $this->newsSourcesFactory->create();
    }
}
