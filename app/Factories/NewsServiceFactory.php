<?php

namespace App\Factories;

use App\Contracts\NewsSourceInterface;
use App\Services\BBC\BBCNewsService;
use App\Services\Guardian\GuardianNewsService;
use App\Services\NewsApi\NewsApiService;
use InvalidArgumentException;

class NewsServiceFactory
{
    public static function make(string $service): NewsSourceInterface
    {
        return match ($service) {
            'bbc' => app(BBCNewsService::class),
            'guardian' => app(GuardianNewsService::class),
            'newsapi' => app(NewsApiService::class),
            default => throw new InvalidArgumentException("Unknown news service: {$service}"),
        };
    }
}
