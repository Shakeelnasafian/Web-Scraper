<?php

namespace App\Providers;

use App\Services\BBC\BBCParser;
use App\Services\BBC\BBCFetcher;
use App\Contracts\ParserInterface;
use App\Contracts\FetcherInterface;
use App\Services\BBC\BBCNormalizer;
use App\Services\BBC\BBCNewsService;
use App\Contracts\NormalizerInterface;
use App\Services\BBC\BBCContentFetcher;
use App\Services\NewsApi\NewsApiParser;
use Illuminate\Support\ServiceProvider;
use App\Services\NewsApi\NewsApiFetcher;
use App\Services\NewsApi\NewsApiService;
use App\Services\Guardian\GuardianParser;
use App\Contracts\ContentFetcherInterface;
use App\Services\Guardian\GuardianFetcher;
use App\Services\NewsApi\NewsApiNormalizer;
use App\Services\Guardian\GuardianNormalizer;
use App\Services\Guardian\GuardianNewsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Guardian contextual bindings
         */
        $this->app->when(GuardianNewsService::class)->needs(FetcherInterface::class)->give(GuardianFetcher::class);
        $this->app->when(GuardianNewsService::class)->needs(ParserInterface::class)->give(GuardianParser::class);
        $this->app->when(GuardianNewsService::class)->needs(NormalizerInterface::class)->give(GuardianNormalizer::class);

        /**
         * NewsAPI contextual bindings
         */
        $this->app->when(NewsApiService::class)->needs(FetcherInterface::class)->give(NewsApiFetcher::class);
        $this->app->when(NewsApiService::class)->needs(ParserInterface::class)->give(NewsApiParser::class);
        $this->app->when(NewsApiService::class)->needs(NormalizerInterface::class)->give(NewsApiNormalizer::class);

        /**
         * BBC contextual bindings
         */
        $this->app->when(BBCNewsService::class)->needs(FetcherInterface::class)->give(BBCFetcher::class);
        $this->app->when(BBCNewsService::class)->needs(ParserInterface::class)->give(BBCParser::class);
        $this->app->when(BBCNewsService::class)->needs(NormalizerInterface::class)->give(BBCNormalizer::class);
        $this->app->when(BBCNormalizer::class)->needs(ContentFetcherInterface::class)->give(BBCContentFetcher::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
