<?php

namespace App\Services\BBC;

use App\Services\AbstractNewsService;

class BBCNewsService extends AbstractNewsService
{

    public function fetchArticles(array $params = []): array
    {
        $raw = $this->fetcher->fetch($params);
        $items = $this->parser->parse($raw);
        return array_map(fn($item) => $this->normalizer->normalize($item, $params), $items);
    }
}
