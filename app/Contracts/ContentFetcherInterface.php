<?php

namespace App\Contracts;

interface ContentFetcherInterface
{
    public function fetchContent(string $url): ?string;
}
