<?php

namespace App\Services\NewsApi;

use App\Contracts\ParserInterface;
use Illuminate\Support\Arr;

class NewsApiParser implements ParserInterface
{
    public function parse(mixed $rawData): array
    {
        return Arr::get($rawData, 'articles', []);
    }
}
