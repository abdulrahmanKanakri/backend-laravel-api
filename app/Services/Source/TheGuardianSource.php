<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;
use App\Enums\Sources;
use Illuminate\Support\Facades\Http;

class TheGuardianSource implements INewsSource
{
    public function __construct(private string $endpoint, private string $apiKey)
    {
    }

    public function fetchNewsList(string $keyword = '', int $page = 0): array
    {
        // here we add 1 to $page because The Guardian starts the pagination from page 1 not 0
        $response = $this->handleRequest($keyword, $page + 1);

        if ($response->ok()) {
            $results = $response->json()["response"]["results"] ?? [];
            return $this->mapToNews($results);
        }

        return [];
    }

    private function handleRequest(string $keyword = '', int $page = 1)
    {
        return Http::get($this->endpoint, [
            'api-key'     => $this->apiKey,
            'q'           => $keyword,
            'page'        => $page,
            'show-fields' => 'byline,trailText,thumbnail',
            'section'     => 'football'
        ]);
    }

    private function mapToNews(array $news)
    {
        return array_map(function ($v) {
            return $this->mapObjectToNews($v);
        }, $news);
    }

    private function mapObjectToNews(mixed $data): NewsEntity
    {
        $title       = $data["webTitle"] ?? "";
        $description = $data["fields"]["trailText"] ?? "";
        $author      = $data["fields"]["byline"] ?? "";
        $url         = $data["webUrl"] ?? "";
        $category    = $data["sectionName"] ?? "";
        $publishedAt = $data["webPublicationDate"] ?? "";
        $thumbnail   = $data["fields"]["thumbnail"] ?? "";
        $source      = Sources::THE_GUARDIAN;
        return new NewsEntity(
            $title,
            $description,
            $author,
            $url,
            $source,
            $category,
            $publishedAt,
            $thumbnail
        );
    }
}
