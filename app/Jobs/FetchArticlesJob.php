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

    public function __construct(NewsSourceInterface $service, StoreOrUpdateArticleAction $action)
    {
        $this->service = $service;
        $this->action = $action;
    }

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
