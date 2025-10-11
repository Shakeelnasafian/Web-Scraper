<?php

namespace App\Contracts;

interface FetcherInterface
{
    /**
 * Fetches data or a resource using optional parameters.
 *
 * @param array $params Optional parameters to configure the fetch operation (for example: filters, pagination, or request-specific options).
 * @return mixed The fetched result; its type and structure are implementation-specific.
 */
public function fetch(array $params = []): mixed;
}