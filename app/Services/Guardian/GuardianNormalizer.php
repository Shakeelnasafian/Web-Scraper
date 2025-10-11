<?php

namespace App\Services\Guardian;

use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class GuardianNormalizer implements NormalizerInterface
{
    /**
     * Convert a Guardian API item array into an ArticleDTO.
     *
     * Maps Guardian fields into an ArticleDTO:
     * - source: `'The Guardian'`
     * - author: `fields.byline`
     * - title: `fields.headline` or falls back to `webTitle`
     * - description: `null`
     * - content: `fields.body`
     * - url: `webUrl`
     * - urlToImage: `fields.thumbnail`
     * - publishedAt: parsed `webPublicationDate` as a Carbon instance, or `null` if missing
     * - category: taken from `$params['category']` if present
     *
     * @param array $item The raw Guardian API item payload.
     * @param array $params Optional parameters; expects an optional `category` key.
     * @return ArticleDTO The resulting ArticleDTO with mapped values.
     */
    public function normalize(array $item, array $params = []): ArticleDTO
    {
        return new ArticleDTO(
            source: 'The Guardian',
            author: Arr::get($item, 'fields.byline'),
            title: Arr::get($item, 'fields.headline', Arr::get($item, 'webTitle')),
            description: null,
            content: Arr::get($item, 'fields.body'),
            url: Arr::get($item, 'webUrl'),
            urlToImage: Arr::get($item, 'fields.thumbnail'),
            publishedAt: isset($item['webPublicationDate']) ? Carbon::parse($item['webPublicationDate']) : null,
            category: data_get($params, 'category'),
        );
    }
}