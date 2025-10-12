<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Factories\NewsServiceFactory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Actions\StoreOrUpdateArticleAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $serviceName;
    protected array $params;

    public function __construct(string $serviceName, array $params)
    {
        $this->serviceName = $serviceName;
        $this->params = $params;
    }

    public function handle(): void
    {
        try {
            $service = NewsServiceFactory::make($this->serviceName);

            Log::info('Fetching articles from service', ['service' => $this->serviceName]);

            $articles = $service->fetchArticles($this->params);

            app(StoreOrUpdateArticleAction::class)->execute($articles);
        } catch (\Throwable $e) {
            Log::error('Error fetching articles', [
                'service' => $this->serviceName,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
