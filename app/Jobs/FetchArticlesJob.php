<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Contracts\NewsSourceInterface;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Actions\StoreOrUpdateArticleAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected NewsSourceInterface $service;
    protected StoreOrUpdateArticleAction $action;

    /**
     * Initialize the job with its news source service and article persistence action.
     *
     * @param NewsSourceInterface $service The news source service used to fetch articles.
     * @param StoreOrUpdateArticleAction $action The action responsible for storing or updating fetched articles.
     */
    public function __construct(NewsSourceInterface $service, StoreOrUpdateArticleAction $action)
    {
        $this->service = $service;
        $this->action = $action;
    }

    /**
     * Fetches articles from the configured news source and delegates their persistence.
     *
     * Any exceptions thrown while fetching or persisting articles are caught and logged
     * with the service class name and the exception message.
     */
    public function handle(): void
    {
        try {
            $articles = $this->service->fetchArticles();

            // delegate all persistence logic to the Action
            $this->action->execute($articles);
        } catch (Throwable $e) {
            Log::error('Error fetching articles', [
                'service' => get_class($this->service),
                'message' => $e->getMessage(),
            ]);
        }
    }
}