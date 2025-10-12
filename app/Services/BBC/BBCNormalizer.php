<?php

namespace App\Services\BBC;

use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use App\Contracts\NormalizerInterface;
use App\Contracts\ContentFetcherInterface;

class BBCNormalizer implements NormalizerInterface
{
    protected ContentFetcherInterface $contentFetcher;

    public function __construct(ContentFetcherInterface $contentFetcher)
    {
        $this->contentFetcher = $contentFetcher;
    }
    
    public function normalize(array $item, array $params = []): ArticleDTO
    {
        $fullContent = $this->contentFetcher->fetchContent(data_get($item, 'link') ?? '');

        return new ArticleDTO(
            source: 'BBC News',
            author: null,
            title: (string) data_get($item, 'title'),
            description: (string) data_get($item, 'description'),
            content: $fullContent,
            url: (string) data_get($item, 'link'),
            urlToImage: null,
            publishedAt: isset($item['pubDate']) ? Carbon::parse($item['pubDate']) : null,
            category: data_get($params, 'category')
        );
    }
}
