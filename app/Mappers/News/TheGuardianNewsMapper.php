<?php

namespace App\Mappers\News;

use App\Entities\NewsEntity;
use App\Enums\Sources;

class TheGuardianNewsMapper implements INewsMapper
{
    public function fromApi(mixed $data): NewsEntity
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
