<?php

namespace App\Mappers\News;

use App\Entities\NewsEntity;
use App\Enums\Sources;

class NewYorkTimesNewsMapper implements INewsMapper
{
    public function __construct(private readonly string $mediaBaseURL)
    {
    }

    public function fromApi(mixed $data): NewsEntity
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
