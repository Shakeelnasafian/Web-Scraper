<?php

namespace App\Services\Guardian;

use App\Contracts\ParserInterface;
use Illuminate\Support\Arr;

class GuardianParser implements ParserInterface
{
    /**
     * Extracts the results array from a raw Guardian API response.
     *
     * @param mixed $rawData The raw response data to parse (typically the decoded API response).
     * @return array The value at `response.results`, or an empty array if that path is missing.
     */
    public function parse(mixed $rawData): array
    {
        return Arr::get($rawData, 'response.results', []);
    }
}