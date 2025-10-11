<?php

namespace App\Services\BBC;

use App\Contracts\ParserInterface;

class BBCParser implements ParserInterface
{
    /**
     * Parse RSS feed items from the provided raw data into a plain array.
     *
     * Converts the items found at `$rawData->channel->item` to an array. Returns an empty
     * array when `$rawData` is falsy or when `channel->item` is not present.
     *
     * @param mixed $rawData Raw RSS-like data expected to contain `channel->item`.
     * @return array The extracted items as an array, or an empty array if none are available.
     */
    public function parse(mixed $rawData): array
    {
        if (!$rawData || !isset($rawData->channel->item)) {
            return [];
        }

        return iterator_to_array($rawData->channel->item);
    }
}