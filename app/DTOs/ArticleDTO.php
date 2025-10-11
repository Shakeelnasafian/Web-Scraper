<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

class ArticleDTO
{
    /**
     * Create a new ArticleDTO containing article metadata.
     *
     * @param string $source The article source identifier or name.
     * @param string|null $author The author name, or null if unknown.
     * @param string $title The article title.
     * @param string|null $description A short description or summary, or null.
     * @param string|null $content The full article content, or null.
     * @param string $url The canonical URL of the article.
     * @param string|null $urlToImage URL to the article's image, or null.
     * @param \Illuminate\Support\Carbon|null $publishedAt The publication date/time as a Carbon instance, or null.
     * @param string|null $category The article category, or null.
     */
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

    /**
     * Convert the ArticleDTO into an associative array for serialization or response payloads.
     *
     * @return array{
     *     source: string,
     *     author: string|null,
     *     title: string,
     *     description: string|null,
     *     content: string|null,
     *     url: string,
     *     url_to_image: string|null,
     *     published_at: string|null,
     *     category: string|null
     * } Associative array representation of the article; `published_at` is a date-time string when present, otherwise `null`.
     */
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