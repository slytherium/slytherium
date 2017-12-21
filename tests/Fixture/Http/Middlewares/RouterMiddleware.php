<?php

namespace Zapheus\Fixture\Http\Middlewares;

use Zapheus\Application;
use Zapheus\Http\Message\ServerRequestInterface;
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
     * Processes an incoming server request and return a response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface        $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $attribute = Application::RESOLVER_ATTRIBUTE;

        $path = $request->getUri()->getPath();

        $method = $request->getMethod();

        $resolver = $this->dispatcher->dispatch($method, $path);

        $request = $request->withAttribute($attribute, $resolver);

        return $handler->handle($request);
    }
}
