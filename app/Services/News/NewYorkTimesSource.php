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

    public function fetchNewsList(string $keyword = ''): array
    {
        $response = $this->handleRequest($keyword);

        if ($response->ok()) {
            $docs = $response->json()["response"]["docs"] ?? [];
            return $this->mapToNews($docs);
        }

        return [];
    }

    private function handleRequest(string $keyword = '')
    {
        return Http::get($this->endpoint, [
            'api-key' => $this->apiKey,
            'q'       => $keyword,
            'sort'    => 'newest',
            'page'    => 0,
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
        $category    = $data["news_desk"] ?? $data["section_name"] ?? "";
        $source      = Sources::NEW_YORK_TIMES;
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
