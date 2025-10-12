<?php

namespace App\Services;

use App\DTOs\ArticleDTO;
use App\Contracts\ParserInterface;
use App\Contracts\FetcherInterface;
use App\Contracts\NewsSourceInterface;
use App\Contracts\NormalizerInterface;

abstract class AbstractNewsService implements NewsSourceInterface
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
