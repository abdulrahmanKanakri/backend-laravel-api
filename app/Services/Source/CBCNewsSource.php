<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;
use App\Enums\Sources;
use Illuminate\Support\Facades\Http;

class CBCNewsSource implements INewsSource
{
    public function __construct(private string $endpoint, private string $apiKey)
    {
    }

    public function fetchNewsList(string $keyword = '', int $page = 0): array
    {
        // here we add 1 to $page because ABC News starts the pagination from page 1 not 0
        $response = $this->handleRequest($keyword, $page + 1);

        if ($response->ok()) {
            $articles = $response->json()["articles"] ?? [];
            return $this->mapToNews($articles);
        }

        return [];
    }

    private function handleRequest(string $keyword = '', int $page = 1)
    {
        return Http::get($this->endpoint, [
            'apiKey'   => $this->apiKey,
            'q'        => $keyword,
            'page'     => $page,
            'pageSize' => 10,
            'sources'  => 'cbc-news'
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
        $title       = $data["title"] ?? "";
        $description = $data["description"] ?? "";
        $author      = $data["author"] ?? "";
        $url         = $data["url"] ?? "";
        $category    = $data["category"] ?? "";
        $publishedAt = $data["publishedAt"] ?? "";
        $thumbnail   = $data["urlToImage"] ?? "";
        $source      = Sources::CBC_NEWS;
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
