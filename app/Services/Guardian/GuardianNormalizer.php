<?php

namespace App\Services\Guardian;

use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class GuardianNormalizer implements NormalizerInterface
{
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
