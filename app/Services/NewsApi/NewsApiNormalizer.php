<?php

namespace App\Services\NewsApi;

use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class NewsApiNormalizer implements NormalizerInterface
{
    public function normalize(array $item, array $params = []): ArticleDTO
    {
        return new ArticleDTO(
            source: data_get($item, 'source.name', 'NewsAPI'),
            author: data_get($item, 'author'),
            title: data_get($item, 'title'),
            description: data_get($item, 'description'),
            content: data_get($item, 'content'),
            url: data_get($item, 'url'),
            urlToImage: data_get($item, 'urlToImage'),
            publishedAt: isset($item['publishedAt']) ? Carbon::parse($item['publishedAt']) : null,
            category: data_get($params, 'category')
        );
    }
}
