<?php

namespace App\Common\Libs\MeiliSearch\Factory;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    function __construct(private string $key)
    {
    }

    public function createRequest(string $method, $uri): RequestInterface
    {
        $request = new Request($method, $uri);
        if (config('scout.meilisearch.key')) {
            $request = $request->withAddedHeader('X-MEILI-API-KEY', $this->key);
        }

        return $request;
    }
}
