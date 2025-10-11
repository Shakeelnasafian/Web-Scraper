<?php

namespace App\Services\BBC;

use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class BBCNormalizer implements NormalizerInterface
{
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
