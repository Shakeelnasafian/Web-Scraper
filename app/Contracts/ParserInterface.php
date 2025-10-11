<?php

namespace App\Contracts;

interface ParserInterface
{
    public function parse(mixed $rawData): array;
}
