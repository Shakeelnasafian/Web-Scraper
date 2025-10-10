<?php

namespace App\Services\News;

use App\Contracts\NewsSourceInterface;

class BBCNewsService implements NewsSourceInterface
{
    protected string $feedUrl;

    public function __construct()
    {
        $this->feedUrl = 'http://feeds.bbci.co.uk/news/rss.xml';
    }

    public function fetchArticles(array $params = []): array
    {
        $rss = @simplexml_load_file($this->feedUrl, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (!$rss || !isset($rss->channel->item)) {
            return [];
        }

        $articles = [];
        foreach ($rss->channel->item as $item) {
            $articles[] = [
                'source' => 'BBC News',
                'author' => null,
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'content' => (string) $item->description,
                'url' => (string) $item->link,
                'url_to_image' => null, // RSS feed often lacks images
                'published_at' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
                'category' => $params['category'] ?? null,
            ];
        }

        return $articles;
    }
}
