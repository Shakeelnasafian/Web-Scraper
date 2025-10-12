<?php

namespace App\Services\BBC;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Contracts\ContentFetcherInterface;

class BBCContentFetcher implements ContentFetcherInterface
{
    public function fetchContent(string $url): ?string
    {
        try {
            $html = Http::get($url)->body();

            $crawler = new Crawler($html);

            // Extract article text blocks
            $paragraphs = $crawler->filter('article p, div[data-component="text-block"] p')->each(
                fn($node) => trim($node->text())
            );

            return implode("\n\n", array_filter($paragraphs));
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }
}
