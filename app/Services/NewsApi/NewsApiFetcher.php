<?php

namespace App\Services\NewsApi;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class NewsApiFetcher implements FetcherInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function fetch(array $params = []): mixed
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey'   => $this->apiKey,
            'category' => data_get($params, 'category', 'general'),
            'language' => data_get($params, 'language', 'en'),
            'pageSize' => 50,
        ]);

        return $response->successful() ? $response->json() : null;
    }
}
