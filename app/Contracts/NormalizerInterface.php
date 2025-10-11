<?php

namespace App\Contracts;

interface NormalizerInterface
{
    public function normalize(array $item, array $params = []): \App\DTOs\ArticleDTO;
}
