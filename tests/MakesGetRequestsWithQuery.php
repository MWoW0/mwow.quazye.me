<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestResponse;

trait MakesGetRequestsWithQuery
{
    public function getWithQuery(string $url, array $query, array $headers = []): TestResponse
    {
        $server = $this->transformHeadersToServerVars($headers);

        return $this->call('GET', $url, $query, [], [], $server);
    }

    public function jsonGetWithQuery(string $url, array $query, array $headers = []): TestResponse
    {
        $headers = array_merge([
            'CONTENT_LENGTH' => 0,
            'CONTENT_TYPE' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);

        return $this->call('GET', $url, $query, [], [], $this->transformHeadersToServerVars($headers), '{}');
    }
}
