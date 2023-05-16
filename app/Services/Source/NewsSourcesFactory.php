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
                    config("services.ny_times.endpoint"),
                    config("services.ny_times.api_key"),
                    config("services.ny_times.media_url")
                );
            case Sources::THE_GUARDIAN:
                return new TheGuardianSource(
                    config("services.the_guardian.endpoint"),
                    config("services.the_guardian.api_key")
                );
            case Sources::BBC_NEWS:
                return new BBCNewsSource(
                    config("services.news_api.endpoint"),
                    config("services.news_api.api_key")
                );
            case Sources::CBC_NEWS:
                return new CBCNewsSource(
                    config("services.news_api.endpoint"),
                    config("services.news_api.api_key")
                );
            default:
                return null;
        }
    }
}
