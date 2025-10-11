<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Collection;

class StoreOrUpdateArticleAction
{
    /**
     * Store or update multiple articles in the database.
     *
     * Normalizes each input article to a consistent data shape, sets `external_id` to the provided value
     * or to `md5(url)` when missing, fills missing `title`, `description`, `url`, and `source` with empty
     * strings, sets `published_at` to the provided value or the current time when missing, and sets
     * `created_at` and `updated_at` to the current time. Processes articles in chunks of 100 and performs
     * an upsert using `external_id` as the unique key; on conflict updates `title`, `description`, `url`,
     * `source`, `published_at`, and `updated_at`.
     *
     * @param array|\Illuminate\Support\Collection $articles Collection or array of associative arrays representing articles.
     *        Each article may contain the keys:
     *        - `external_id` (string, optional) — unique identifier; if absent, `md5(url)` is used.
     *        - `title` (string, optional)
     *        - `description` (string, optional)
     *        - `url` (string, optional)
     *        - `source` (string, optional)
     *        - `published_at` (\DateTime|string, optional)
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