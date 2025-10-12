<?php

namespace App\Services\BBC;

use App\Contracts\FetcherInterface;
use Illuminate\Support\Facades\Http;

class BBCFetcher implements FetcherInterface
{
    protected string $feedUrl;

    public function __construct()
    {
        $this->feedUrl = config('services.bbc.url');
    }

    public function fetch(array $params = []): ?\SimpleXMLElement
    {
        $response = Http::get($this->feedUrl);

        if (!$response->successful()) {
            return null;
        }

        return simplexml_load_string($response->body());
    }
}
