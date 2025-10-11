<?php

namespace App\Services\Guardian;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class GuardianFetcher implements FetcherInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    public function fetch(array $params = []): mixed
    {
        $response = Http::get('https://content.guardianapis.com/search', [
            'api-key' => $this->apiKey,
            'section' => data_get($params, 'category'),
            'page-size' => 50,
            'show-fields' => 'headline,body,thumbnail,byline',
        ]);

        return $response->successful() ? $response->json() : null;
    }
}
