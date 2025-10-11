<?php

namespace App\Services\BBC;

use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class BBCNormalizer implements NormalizerInterface
{
    /**
     * Normalize a raw BBC feed item into an ArticleDTO.
     *
     * Converts a BBC feed item array into an ArticleDTO with source set to "BBC News".
     *
     * @param array $item Associative array representing a BBC feed item; expects 'title', 'description', 'link', and optionally 'pubDate'.
     * @param array $params Optional parameters; supports 'category' to set the DTO's category.
     * @return ArticleDTO ArticleDTO populated from the item (publishedAt parsed from 'pubDate' when present, otherwise null).
     */
    public function normalize(array $item, array $params = []): ArticleDTO
    {
        return new ArticleDTO(
            source: 'BBC News',
            author: null,
            title: (string) data_get($item, 'title'),
            description: (string) data_get($item, 'description'),
            content: (string) data_get($item, 'description'),
            url: (string) data_get($item, 'link'),
            urlToImage: null,
            publishedAt: isset($item['pubDate']) ? Carbon::parse($item['pubDate']) : null,
            category: data_get($params, 'category')
        );
    }
}