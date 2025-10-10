<?php

namespace App\Services\News;

use App\Contracts\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class GuardianService implements NewsSourceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key'); // store in .env
    }

    public function fetchArticles(array $params = []): array
    {
        $response = Http::get('https://content.guardianapis.com/search', [
            'api-key' => $this->apiKey,
            'section' => $params['category'] ?? null,
            'page-size' => 50,
            'show-fields' => 'headline,body,thumbnail,byline',
        ]);

        if (!$response->successful() || !isset($response->json()['response']['results'])) {
            return [];
        }

        return collect($response->json()['response']['results'])->map(fn($item) => [
            'source' => 'The Guardian',
            'author' => $item['fields']['byline'] ?? null,
            'title' => $item['fields']['headline'] ?? $item['webTitle'],
            'description' => null,
            'content' => $item['fields']['body'] ?? null,
            'url' => $item['webUrl'],
            'url_to_image' => $item['fields']['thumbnail'] ?? null,
            'published_at' => $item['webPublicationDate'] ?? null,
            'category' => $params['category'] ?? null,
        ])->toArray();
    }
}
