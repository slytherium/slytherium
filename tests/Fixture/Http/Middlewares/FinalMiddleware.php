<?php

namespace Slytherium\Fixture\Http\Middlewares;

use Slytherium\Http\Message\Response;
use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\HandlerInterface;
use Slytherium\Http\Server\MiddlewareInterface;

/**
 * Final Middleware
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FinalMiddleware implements MiddlewareInterface
{
    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \ServerRequestInterface $request
     * @param  \HandlerInterface       $handler
     * @return \ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        return new Response;
    }
}
