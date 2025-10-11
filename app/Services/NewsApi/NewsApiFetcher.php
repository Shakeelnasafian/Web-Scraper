<?php

namespace App\Services\NewsApi;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class NewsApiFetcher implements FetcherInterface
{
    protected string $apiKey;

    /**
     * Initialize the fetcher by loading the NewsAPI API key from configuration.
     *
     * The API key is read from `services.newsapi.key` and stored in `$this->apiKey`.
     */
    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    /**
     * Fetches top headlines from NewsAPI using optional category and language parameters.
     *
     * @param array $params Optional parameters: 'category' (defaults to 'general'), 'language' (defaults to 'en').
     * @return array|null The decoded JSON response as an associative array on success, `null` on failure.
     */
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