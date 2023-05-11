<?php

namespace App\Services\News;

use App\Entities\NewsEntity;
use App\Enums\Sources;
use Illuminate\Support\Facades\Http;

class NewYorkTimesSource implements INewsSource
{
    public function __construct(private string $endpoint, private string $apiKey)
    {
    }

    public function fetchNewsList(string $keyword = '', int $page = 0): array
    {
        $response = $this->handleRequest($keyword, $page);

        if ($response->ok()) {
            $docs = $response->json()["response"]["docs"] ?? [];
            return $this->mapToNews($docs);
        }

        return [];
    }

    private function handleRequest(string $keyword = '', int $page = 0)
    {
        return Http::get($this->endpoint, [
            'api-key' => $this->apiKey,
            'q'       => $keyword,
            'sort'    => 'newest',
            'page'    => $page,
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
        $title       = $data["headline"]["main"] ?? "";
        $description = $data["abstract"] ?? $data["snippet"] ?? "";
        $author      = $data["byline"]["original"] ?? "";
        $url         = $data["web_url"] ?? "";
        $source      = Sources::NEW_YORK_TIMES;
        $category    = $data["news_desk"] ?? $data["section_name"] ?? "";
        return new NewsEntity(
            $title,
            $description,
            $author,
            $url,
            $source,
            $category
        );
    }
}
