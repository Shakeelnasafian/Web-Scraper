<?php

namespace App\Services\NewsApi;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class NewsApiFetcher implements FetcherInterface
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
        $this->apiUrl = config('services.newsapi.url');
    }

    public function fetch(array $params = []): mixed
    {
        $response = Http::get($this->apiUrl, [
            'apiKey'   => $this->apiKey,
            'category' => data_get($params, 'category', 'general'),
            'language' => data_get($params, 'language', 'en'),
            'pageSize' => 50,
        ]);

        return $response->successful() ? $response->json() : null;
    }
}
