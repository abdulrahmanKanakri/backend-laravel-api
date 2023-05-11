<?php

namespace App\Services\News;

class AggregatedSources implements INewsSource
{
    private $sources;

    public function __construct(INewsSource ...$sources)
    {
        $this->sources = $sources;
    }

    public function fetchNewsList(string $keyword = '', int $page = 0): array
    {
        $news = [];

        foreach ($this->sources as $source) {
            array_push($news, ...$source->fetchNewsList($keyword, $page));
        }

        return $news;
    }
}
