<?php

namespace App\Services\Source;

class AggregatedSources implements INewsSource
{
    private $sources;

    public function __construct(INewsSource ...$sources)
    {
        $this->sources = $sources;
    }

    public function fetchNewsList(array $filters): array
    {
        $news = collect([]);

        foreach ($this->sources as $source) {
            $news->push(...$source->fetchNewsList($filters));
        }

        return $news->sortByDesc("publishedAt")->values()->all();
    }
}
