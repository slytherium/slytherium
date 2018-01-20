<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\RequestInterface;

/**
 * Next Handler
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class NextHandler implements HandlerInterface
{
    /**
     * @var \Zapheus\Http\Server\MiddlewareInterface
     */
    protected $middleware;

    /**
     * @var \Zapheus\Http\Server\HandlerInterface
     */
    protected $handler;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Http\Server\MiddlewareInterface $middleware
     * @param \Zapheus\Http\Server\HandlerInterface    $handler
     */
    public function __construct(MiddlewareInterface $middleware, HandlerInterface $handler)
    {
        $this->middleware = $middleware;

        $this->handler = $handler;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function __invoke(RequestInterface $request)
    {
        return $this->handle($request);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        return $this->middleware->process($request, $this->handler);
    }
}
