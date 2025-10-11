<?php

namespace App\Services\BBC;

use App\Contracts\ParserInterface;

class BBCParser implements ParserInterface
{
    public function parse(mixed $rawData): array
    {
        if (!$rawData || !isset($rawData->channel->item)) {
            return [];
        }

        return iterator_to_array($rawData->channel->item);
    }
}
