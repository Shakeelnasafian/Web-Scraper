<?php

namespace App\Services\NewsApi;

use App\Contracts\ParserInterface;
use Illuminate\Support\Arr;

class NewsApiParser implements ParserInterface
{
    /**
     * Extracts the list of articles from a raw News API response.
     *
     * @param mixed $rawData Raw response data from the News API (array or object containing an `articles` key).
     * @return array The value of the `articles` key as an array; an empty array if `articles` is not present.
     */
    public function parse(mixed $rawData): array
    {
        return Arr::get($rawData, 'articles', []);
    }
}