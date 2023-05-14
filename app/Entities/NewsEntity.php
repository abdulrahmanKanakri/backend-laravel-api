<?php

namespace App\Entities;

class NewsEntity
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $author,
        public readonly string $url,
        public readonly string $source,
        public readonly string $category,
        public readonly string $publishedAt,
        public readonly string $thumbnail = "",
    ) {
    }
}
