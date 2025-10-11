<?php

namespace App\Services;

use App\Contracts\FetcherInterface;
use App\Contracts\ParserInterface;
use App\Contracts\NormalizerInterface;
use App\DTOs\ArticleDTO;

abstract class AbstractNewsService
{
    /**
     * Create a new AbstractNewsService with the required fetcher, parser, and normalizer.
     */
    public function __construct(
        protected FetcherInterface $fetcher,
        protected ParserInterface $parser,
        protected NormalizerInterface $normalizer
    ) {}

    /**
     * Fetches raw data, parses and normalizes items, and returns only articles that have both a title and a URL.
     *
     * @param array $params Optional parameters forwarded to the fetcher and normalizer to influence fetching/parsing/normalization.
     * @return ArticleDTO[] Array of ArticleDTO objects that have a non-empty `title` and `url`.
     */
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