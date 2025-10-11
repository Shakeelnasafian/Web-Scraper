<?php

namespace App\Contracts;

interface ParserInterface
{
    /**
 * Convert raw input into a structured array representation.
 *
 * @param mixed $rawData The raw input to be parsed (e.g., string, array, object, resource).
 * @return array An array representing the parsed data.
 */
public function parse(mixed $rawData): array;
}