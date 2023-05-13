<?php

namespace App\Services\Source;

use App\Enums\Sources;
use App\Services\User\ICurrentUserService;

class NewsSourcesFactory
{
    public function __construct(private ICurrentUserService $currentUserService)
    {
    }

    public function create(): INewsSource
    {
        $sources = $this->currentUserService->user()->sources;

        $newsSources = $this->getNewsSources($sources);

        if (count($newsSources) == 1) {
            return $newsSources[0];
        }

        return new AggregatedSources(...$newsSources);
    }

    /**
     * @return array<int, INewsSource>
     */
    private function getNewsSources(mixed $sources): array
    {
        /** @var array<int, INewsSource> $newsSources */
        $newsSources = [];

        foreach ($sources as $source) {
            $newsSource = $this->getNewsSource($source->name);
            if ($newsSource) {
                array_push($newsSources, $newsSource);
            }
        }

        return $newsSources;
    }

    private function getNewsSource(string $sourceName): INewsSource
    {
        switch ($sourceName) {
            case Sources::NEW_YORK_TIMES:
                return new NewYorkTimesSource(
                    env("NEW_YORK_TIMES_ENDPOINT"),
                    env("NEW_YORK_TIMES_API_KEY")
                );
            case Sources::THE_GUARDIAN:
                return new TheGuardianSource(
                    env("THE_GUARDIAN_ENDPOINT"),
                    env("THE_GUARDIAN_API_KEY")
                );
            case Sources::BBC_NEWS:
                return new BBCNewsSource(
                    env("NEWSAPI_ENDPOINT"),
                    env("NEWSAPI_API_KEY")
                );
            case Sources::CBC_NEWS:
                return new CBCNewsSource(
                    env("NEWSAPI_ENDPOINT"),
                    env("NEWSAPI_API_KEY")
                );
            default:
                return null;
        }
    }
}
