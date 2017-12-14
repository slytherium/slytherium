<?php

namespace Slytherium\Http\Server;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Last Middleware
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class LastMiddleware implements MiddlewareInterface
{
    /**
     * @var \Slytherium\Http\Server\HandlerInterface
     */
    protected $handler;

    /**
     * Initializes the middleware instance.
     *
     * @param \Slytherium\Http\Server\HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @param  \Slytherium\Http\Server\HandlerInterface        $handler
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        return $this->handler->handle($request);
    }
}
