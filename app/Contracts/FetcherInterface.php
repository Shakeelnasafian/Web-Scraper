<?php

namespace App\Contracts;

interface FetcherInterface
{
    public function fetch(array $params = []): mixed;
}
