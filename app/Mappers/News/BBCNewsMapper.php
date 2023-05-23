<?php

namespace App\Mappers\News;

use App\Entities\NewsEntity;
use App\Enums\Sources;

class BBCNewsMapper implements INewsMapper
{
    public function fromApi(mixed $data): NewsEntity
    {
        $title       = $data["title"] ?? "";
        $description = $data["description"] ?? "";
        $author      = $data["author"] ?? "";
        $url         = $data["url"] ?? "";
        $category    = $data["category"] ?? "";
        $publishedAt = $data["publishedAt"] ?? "";
        $thumbnail   = $data["urlToImage"] ?? "";
        $source      = Sources::BBC_NEWS;
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
