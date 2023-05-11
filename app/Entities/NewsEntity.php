<?php

namespace App\Entities;

use JsonSerializable;

class NewsEntity implements JsonSerializable
{
    public function __construct(
        private string $title,
        private string $description,
        private string $author,
        private string $url,
        private string $source,
        private string $category,
        private string $thumbnail = "",
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function jsonSerialize()
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'author'      => $this->author,
            'url'         => $this->url,
            'source'      => $this->source,
            'category'    => $this->category,
            'thumbnail'   => $this->thumbnail,
        ];
    }
}
