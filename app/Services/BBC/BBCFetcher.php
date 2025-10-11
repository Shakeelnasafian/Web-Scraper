<?php

namespace App\Services\BBC;

use App\Contracts\FetcherInterface;

class BBCFetcher implements FetcherInterface
{
    protected string $feedUrl = 'http://feeds.bbci.co.uk/news/rss.xml';

    /**
     * Fetches and parses the BBC RSS feed.
     *
     * @param array $params Optional parameters influencing the fetch (currently unused).
     * @return \SimpleXMLElement|null The parsed feed as a SimpleXMLElement on success, `null` on failure.
     */
    public function fetch(array $params = []): ?\SimpleXMLElement
    {
        return @simplexml_load_file($this->feedUrl, 'SimpleXMLElement', LIBXML_NOCDATA);
    }
}