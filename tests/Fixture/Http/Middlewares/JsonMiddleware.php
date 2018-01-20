<?php

namespace Zapheus\Fixture\Http\Middlewares;

use Zapheus\Http\Message\RequestInterface;
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
     * Processes an incoming request and return a response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface  $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(RequestInterface $request, HandlerInterface $handler)
    {
        $response = $handler->handle($request);

        $original = $headers = $response->headers();

        $headers->set('Content-Type', array('application/json'));

        $new = $response->set('headers', $headers);

        return $original->has('Content-Type') ? $response : $new;
    }
}
