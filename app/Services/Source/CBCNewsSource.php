<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;
use App\Enums\Categories;
use App\Enums\Sources;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CBCNewsSource implements INewsSource
{
    public function __construct(private string $endpoint, private string $apiKey)
    {
    }

    public function fetchNewsList(array $filters): array
    {
        $data = $this->handleRequest($filters);

        return $this->mapToNews($data);
    }

    private function handleRequest(array $filters)
    {
        try {
            $params = $this->handleRequestParams($filters);

            $response = Http::get($this->endpoint, $params);

            if ($response->ok()) {
                return $response->json()["articles"];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [];
    }

    private function handleRequestParams(array $filters)
    {
        if (isset($filters['category'])) {
            $categories = Categories::getSourceCategories(Sources::CBC_NEWS);
            $filters['category'] = $categories[$filters['category']][0] ?? '';
        }

        return collect([
            'apiKey'   => $this->apiKey,
            'q'        => $filters['keyword'] ?? '',
            'page'     => $filters['page'] ??  1,
            'pageSize' => 5,
            'sources'  => 'cbc-news'
        ])->filter()->all();
    }

    private function mapToNews(array $news)
    {
        return array_map(fn ($v) => $this->mapObjectToNews($v), $news);
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
