<?php

namespace Slytherium\Fixture\Http\Middlewares;

use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\HandlerInterface;
use Slytherium\Http\Server\MiddlewareInterface;

/**
 * JSON Middleware
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonMiddleware implements MiddlewareInterface
{
    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @param  \Slytherium\Http\Server\HandlerInterface $handler
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $response = $handler->handle($request);

        $new = $response->withHeader('Content-Type', 'application/json');

        return $response->hasHeader('Content-Type') ? $response : $new;
    }
}
