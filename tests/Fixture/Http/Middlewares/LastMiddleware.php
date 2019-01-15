<?php

namespace Zapheus\Fixture\Http\Middlewares;

use Zapheus\Http\Message\Response;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Server\HandlerInterface;
use Zapheus\Http\Server\MiddlewareInterface;

/**
 * Last Middleware
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class LastMiddleware implements MiddlewareInterface
{
    /**
     * Processes an incoming request and returns a response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface  $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(RequestInterface $request, HandlerInterface $handler)
    {
        return new Response;
    }
}
