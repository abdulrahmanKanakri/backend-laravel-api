<?php

namespace App\Services\Source;

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
            'api-key'      => $this->apiKey,
            'q'            => $keyword,
            'sort'         => 'newest',
            'page'         => $page,
            'facet_filter' => true,
            'facet_fields' => 'section_name',
            'fq'           => 'Sports', // category
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
        return $path ? 'https://static01.nyt.com/' . $path : "";
    }
}
