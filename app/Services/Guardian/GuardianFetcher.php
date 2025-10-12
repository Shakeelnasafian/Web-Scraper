<?php

namespace App\Services\Guardian;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class GuardianFetcher implements FetcherInterface
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
        $this->apiUrl = config('services.guardian.url');
    }

    public function fetch(array $params = []): mixed
    {
        $response = Http::get($this->apiUrl, [
            'api-key' => $this->apiKey,
            'section' => data_get($params, 'category'),
            'page-size' => 50,
            'show-fields' => 'headline,body,thumbnail,byline',
        ]);

        return $response->successful() ? $response->json() : null;
    }
}
