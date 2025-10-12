<?php

namespace App\Services\BBC;

use SimpleXMLElement;
use App\Contracts\ParserInterface;

class BBCParser implements ParserInterface
{
    public function parse(mixed $rawData): array
    {
        if (!$rawData instanceof SimpleXMLElement) {
            return [];
        }

        $items = $rawData->channel->item ?? [];
        $parsed = [];
        
        foreach ($items as $item) {
            $parsed[] = [
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'link' => (string) $item->link,
                'pubDate' => (string) $item->pubDate,
            ];
        }

        return $parsed;
    }
}
