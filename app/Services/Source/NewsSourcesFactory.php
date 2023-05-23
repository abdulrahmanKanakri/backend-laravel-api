<?php

namespace App\Services\Source;

use App\Enums\Sources;
use App\Mappers\News\BBCNewsMapper;
use App\Mappers\News\CBCNewsMapper;
use App\Mappers\News\NewYorkTimesNewsMapper;
use App\Mappers\News\TheGuardianNewsMapper;
use App\Services\User\ICurrentUserService;
use stdClass;

class NewsSourcesFactory
{
    public function __construct(private ICurrentUserService $currentUserService)
    {
    }

    public function create(): INewsSource
    {
        $sources = $this->getUserSources();

        $newsSources = $this->getNewsSources($sources);

        return $this->getNewsSourcesAccordingToCount($newsSources);
    }

    /**
     * @param array<int, string> $sourcesList
     */
    public function createFromList(array $sourcesList): INewsSource
    {
        $sources = $this->mapSourcesList($sourcesList);

        $newsSources = $this->getNewsSources($sources);

        return $this->getNewsSourcesAccordingToCount($newsSources);
    }

    private function getUserSources()
    {
        $sources = $this->currentUserService->user()->sources;

        return count($sources) > 0 ? $sources : $this->getDefaultSources();
    }

    private function getDefaultSources()
    {
        return $this->mapSourcesList(Sources::getConstants());
    }

    private function mapSourcesList(array $sourcesList)
    {
        $sources = [];

        foreach ($sourcesList as $name) {
            $source = $this->mapSourceToObject($name);
            array_push($sources, $source);
        }

        return $sources;
    }

    private function mapSourceToObject(string $name)
    {
        $source = new stdClass();
        $source->name = $name;
        return $source;
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
                    new NewYorkTimesNewsMapper(config("services.ny_times.media_url"))
                );
            case Sources::THE_GUARDIAN:
                return new TheGuardianSource(
                    config("services.the_guardian.endpoint"),
                    config("services.the_guardian.api_key"),
                    new TheGuardianNewsMapper(),
                );
            case Sources::BBC_NEWS:
                return new BBCNewsSource(
                    config("services.news_api.endpoint"),
                    config("services.news_api.api_key"),
                    new BBCNewsMapper(),
                );
            case Sources::CBC_NEWS:
                return new CBCNewsSource(
                    config("services.news_api.endpoint"),
                    config("services.news_api.api_key"),
                    new CBCNewsMapper(),
                );
            default:
                return null;
        }
    }

    /**
     * @param array<int, INewsSource> $newsSources
     */
    private function getNewsSourcesAccordingToCount(array $newsSources): INewsSource
    {
        if (count($newsSources) == 1) {
            return $newsSources[0];
        }

        return new AggregatedSources(...$newsSources);
    }
}
