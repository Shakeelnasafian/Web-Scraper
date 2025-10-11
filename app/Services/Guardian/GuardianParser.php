<?php

namespace App\Services\Guardian;

use App\Contracts\ParserInterface;
use Illuminate\Support\Arr;

class GuardianParser implements ParserInterface
{
    public function parse(mixed $rawData): array
    {
        return Arr::get($rawData, 'response.results', []);
    }
}
