<?php

namespace App\Contracts;

interface NormalizerInterface
{
    /**
 * Normalize an associative item array into an ArticleDTO.
 *
 * @param array $item The associative array of raw article data to normalize.
 * @param array $params Optional normalization options that influence how the item is transformed (e.g., formatting or locale settings).
 * @return \App\DTOs\ArticleDTO The resulting ArticleDTO populated from the provided item.
 */
public function normalize(array $item, array $params = []): \App\DTOs\ArticleDTO;
}