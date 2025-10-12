<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchArticlesJob;

class FetchAllNews extends Command
{
    protected $signature = 'news:fetch-all';
    protected $description = 'Fetch articles from all news sources and store them';

    public function handle(): int
    {
        $this->info('Dispatching news fetch jobs...');

        $params = ['category' => 'general'];

        foreach (['bbc', 'guardian', 'newsapi'] as $service) {
            FetchArticlesJob::dispatch($service, $params);
        }

        $this->info('All jobs dispatched successfully.');
        return 0;
    }
}
