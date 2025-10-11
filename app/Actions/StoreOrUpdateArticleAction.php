<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Collection;

class StoreOrUpdateArticleAction
{
    /**
     * @param array|Collection $articles
     */
    public function execute($articles): void
    {
        $articles = collect($articles)
            ->map(function ($article) {
                return [
                    'external_id' => $article['external_id'] ?? md5($article['url']),
                    'title' => $article['title'] ?? '',
                    'description' => $article['description'] ?? '',
                    'url' => $article['url'] ?? '',
                    'source' => $article['source'] ?? '',
                    'published_at' => $article['published_at'] ?? now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

        $articles->chunk(100)->each(function ($chunk) {
            Article::upsert(
                $chunk->toArray(),
                ['external_id'],
                ['title', 'description', 'url', 'source', 'published_at', 'updated_at']
            );
        });
    }
}
