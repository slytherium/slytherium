<?php

namespace Slytherium\Http\Server;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Next Handler
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class NextHandler implements HandlerInterface
{
    /**
     * @var \Slytherium\Http\Server\MiddlewareInterface
     */
    protected $middleware;

    /**
     * @var \Slytherium\Http\Server\HandlerInterface
     */
    protected $handler;

    /**
     * Initializes the handler instance.
     *
     * @param \Slytherium\Http\Server\MiddlewareInterface $middleware
     * @param \Slytherium\Http\Server\HandlerInterface    $handler
     */
    public function __construct(MiddlewareInterface $middleware, HandlerInterface $handler)
    {
        $this->middleware = $middleware;

        $this->handler = $handler;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return $this->handle($request);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        return $this->middleware->process($request, $this->handler);
    }
}
