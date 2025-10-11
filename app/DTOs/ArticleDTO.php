<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

class ArticleDTO
{
    public function __construct(
        public readonly string $source,
        public readonly ?string $author,
        public readonly string $title,
        public readonly ?string $description,
        public readonly ?string $content,
        public readonly string $url,
        public readonly ?string $urlToImage,
        public readonly ?Carbon $publishedAt,
        public readonly ?string $category
    ) {}

    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'url_to_image' => $this->urlToImage,
            'published_at' => optional($this->publishedAt)?->toDateTimeString(),
            'category' => $this->category,
        ];
    }
}
