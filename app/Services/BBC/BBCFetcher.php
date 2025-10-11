<?php

namespace App\Services\BBC;

use App\Contracts\FetcherInterface;

class BBCFetcher implements FetcherInterface
{
    protected string $feedUrl = 'http://feeds.bbci.co.uk/news/rss.xml';

    public function fetch(array $params = []): ?\SimpleXMLElement
    {
        return @simplexml_load_file($this->feedUrl, 'SimpleXMLElement', LIBXML_NOCDATA);
    }
}
