<?php

namespace App\Contracts;

interface NewsSourceInterface
{
    /**
     * Fetch articles from the source.
     *
     * @param array $params
     * @return array
     */
    public function fetchArticles(array $params = []): array;
}
