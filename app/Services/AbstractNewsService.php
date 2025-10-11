<?php

namespace App\Services;

use App\Contracts\FetcherInterface;
use App\Contracts\ParserInterface;
use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;

abstract class AbstractNewsService
{
    public function __construct(
        protected FetcherInterface $fetcher,
        protected ParserInterface $parser,
        protected NormalizerInterface $normalizer
    ) {}

    public function fetchArticles(array $params = []): array
    {
        $rawData = $this->fetcher->fetch($params);
        $items = $this->parser->parse($rawData);

        return collect($items)
            ->map(fn($item) => $this->normalizer->normalize($item, $params))
            ->filter(fn(ArticleDTO $dto) => !empty($dto->title) && !empty($dto->url))
            ->values()
            ->toArray();
    }
}
