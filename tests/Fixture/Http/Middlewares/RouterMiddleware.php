<?php

namespace Zapheus\Fixture\Http\Middlewares;

use Zapheus\Application;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Server\HandlerInterface;
use Zapheus\Http\Server\MiddlewareInterface;
use Zapheus\Routing\DispatcherInterface;

/**
 * Router Middleware
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterMiddleware implements MiddlewareInterface
{
    /**
     * @var \Zapheus\Routing\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Initializes the dispatcher instance.
     *
     * @param \Zapheus\Routing\DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Processes an incoming request and returns a response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface  $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(RequestInterface $request, HandlerInterface $handler)
    {
        $attribute = Application::ROUTE_ATTRIBUTE;

        $path = (string) $request->uri()->path();

        $method = (string) $request->method();

        $route = $this->dispatcher->dispatch($method, $path);

        $request = $request->push('attributes', $route, $attribute);

        return $handler->handle($request);
    }
}
