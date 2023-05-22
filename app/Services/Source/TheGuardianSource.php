<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;
use App\Enums\Categories;
use App\Enums\Sources;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TheGuardianSource implements INewsSource
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
                return $response->json()["response"]["results"];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [];
    }

    private function handleRequestParams(array $filters)
    {
        if (isset($filters['category'])) {
            $categories = Categories::getSourceCategories(Sources::THE_GUARDIAN);
            $filters['category'] = $categories[$filters['category']][0] ?? '';
        }

        return collect([
            'api-key'     => $this->apiKey,
            'q'           => $filters['keyword'] ?? '',
            'section'     => $filters['category'] ?? '',
            'page'        => $filters['page'] ?? 1,
            'show-fields' => 'byline,trailText,thumbnail',
        ])->filter()->all();
    }

    private function mapToNews(array $news)
    {
        return array_map(fn ($v) => $this->mapObjectToNews($v), $news);
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
