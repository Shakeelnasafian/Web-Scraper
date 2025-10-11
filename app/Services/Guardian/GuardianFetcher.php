<?php

namespace App\Services\Guardian;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class GuardianFetcher implements FetcherInterface
{
    protected string $apiKey;

    /**
     * Initialize the fetcher with the Guardian API key from configuration.
     *
     * Retrieves the API key from config('services.guardian.key') and stores it on the instance.
     */
    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    /**
     * Fetches articles from The Guardian content API using the provided parameters.
     *
     * @param array $params Optional parameters. Recognized keys:
     *                      - 'category': string — maps to the API `section` query parameter.
     * @return array|null Associative array decoded from the API JSON response on success, `null` if the HTTP request was not successful.
     */
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