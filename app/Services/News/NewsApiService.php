<?php

namespace App\Services\News;

use App\Contracts\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class NewsApiService implements NewsSourceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function fetchArticles(array $params = []): array
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => $this->apiKey,
            'category' => $params['category'] ?? 'general',
            'language' => $params['language'] ?? 'en',
            'pageSize' => 50
        ]);

        if (!$response->successful()) return [];

        return collect($response->json()['articles'])->map(fn($article) => [
            'source' => $article['source']['name'] ?? 'NewsAPI',
            'author' => $article['author'] ?? null,
            'title' => $article['title'],
            'description' => $article['description'] ?? null,
            'content' => $article['content'] ?? null,
            'url' => $article['url'],
            'url_to_image' => $article['urlToImage'] ?? null,
            'published_at' => $article['publishedAt'] ?? null,
            'category' => $article['category'] ?? null,
        ])->toArray();
    }
}
