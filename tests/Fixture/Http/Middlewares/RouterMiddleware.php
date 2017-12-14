<?php

namespace Slytherium\Fixture\Http\Middlewares;

use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\HandlerInterface;
use Slytherium\Http\Server\MiddlewareInterface;
use Slytherium\Routing\DispatcherInterface;

/**
 * Router Middleware
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterMiddleware implements MiddlewareInterface
{
    /**
     * @var \Slytherium\Routing\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Initializes the dispatcher instance.
     *
     * @param \Slytherium\Routing\DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
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
        $attribute = Application::RESOLVER_ATTRIBUTE;

        $path = $request->getUri()->getPath();

        $method = $request->getMethod();

        $resolver = $this->dispatcher->dispatch($method, $path);

        $request = $request->withAttribute($attribute, $resolver);

        return $handler->handle($request);
    }
}
