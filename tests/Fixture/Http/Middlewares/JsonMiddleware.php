<?php

namespace Zapheus\Fixture\Http\Middlewares;

use Zapheus\Http\Message\ServerRequestInterface;
use Zapheus\Http\Server\HandlerInterface;
use Zapheus\Http\Server\MiddlewareInterface;

/**
 * JSON Middleware
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonMiddleware implements MiddlewareInterface
{
    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface        $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $response = $handler->handle($request);

        $new = $response->withHeader('Content-Type', 'application/json');

        return $response->hasHeader('Content-Type') ? $response : $new;
    }
}
