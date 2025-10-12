<?php

namespace App\Actions;

use App\Models\Article;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\DTOs\ArticleDTO;

class StoreOrUpdateArticleAction
{
    /**
     * @param array|Collection<int, ArticleDTO> $articles
     */
    public function execute($articles): void
    {
        $articles = collect($articles)->map(function (ArticleDTO $article) {
            return array_merge($article->toArray(), [
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        });

        Log::info('Storing or updating articles', ['count' => $articles->count()]);

        $articles->chunk(100)->each(function ($chunk) {
            Article::upsert(
                $chunk->toArray(),
                ['url'],
                ['description', 'content', 'url', 'author', 'source', 'url_to_image', 'published_at', 'updated_at']
            );
        });
    }
}
