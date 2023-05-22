<?php

namespace App\Services\Source;

use App\Entities\NewsEntity;
use App\Enums\Categories;
use App\Enums\Sources;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewYorkTimesSource implements INewsSource
{
    public function __construct(
        private string $endpoint,
        private string $apiKey,
        private string $mediaBaseURL
    ) {
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
                return $response->json()["response"]["docs"];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return [];
    }

    private function handleRequestParams(array $filters)
    {
        $categoryFilters = [];
        if (isset($filters['category'])) {
            $categories = Categories::getSourceCategories(Sources::NEW_YORK_TIMES);
            $categoryFilters = [
                'facet_filter' => true,
                'facet_fields' => 'section_name',
                'fq'           =>  $categories[$filters['category']][0] ?? '',
            ];
        }

        return collect([
            'api-key'      => $this->apiKey,
            'q'            => $filters['keyword'] ?? '',
            'page'         => $filters['page'] ?? 1,
            'sort'         => 'newest',
        ])->merge($categoryFilters)->filter()->all();
    }

    private function mapToNews(array $news)
    {
        return array_map(fn ($v) => $this->mapObjectToNews($v), $news);
    }

    private function mapObjectToNews(mixed $data): NewsEntity
    {
        $title       = $data["headline"]["main"] ?? "";
        $description = $data["abstract"] ?? $data["snippet"] ?? "";
        $author      = $data["byline"]["original"] ?? "";
        $url         = $data["web_url"] ?? "";
        $category    = $data["section_name"] ?? $data["subsection_name"] ?? $data["news_desk"] ?? "";
        $publishedAt = $data["pub_date"] ?? "";
        $thumbnail   = $this->extractThumbnail($data["multimedia"][0]["url"] ?? "");
        $source      = Sources::NEW_YORK_TIMES;
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

    private function extractThumbnail(string $path): string
    {
        return $path ? implode('/', [rtrim($this->mediaBaseURL, '/'), ltrim($path, '/')]) : '';
    }
}
