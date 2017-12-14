<?php

namespace Slytherium\Http\Server;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Middleware Dispatcher
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    protected $stack = array();

    /**
     * Initializes the dispatcher instance.
     *
     * @param array $stack
     */
    public function __construct(array $stack = array())
    {
        foreach ((array) $stack as $item) {
            is_string($item) && $item = new $item;

            array_push($this->stack, $item);
        }
    }

    /**
     * Dispatches the defined middleware stack.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $resolved = $this->resolve(0);

        return $resolved->handle($request);
    }

    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @param  \Slytherium\Http\Server\HandlerInterface $handler
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        array_push($this->stack, new LastMiddleware($handler));

        ($response = $this->dispatch($request)) && array_pop($this->stack);

        return $response;
    }

    /**
     * Adds a new middleware to the stack.
     *
     * @param  \Slytherium\Http\Server\MiddlewareInterface $middleware
     * @return self
     */
    public function pipe(MiddlewareInterface $middleware)
    {
        $this->stack[] = $middleware;

        return $this;
    }

    /**
     * Resolves the whole stack through its index.
     *
     * @param  integer $index
     * @return \Slytherium\Http\Server\HandlerInterface
     */
    protected function resolve($index)
    {
        $arguments = array();

        if (isset($this->stack[$index]) === true) {
            $next = $this->resolve($index + 1);

            $item = $this->stack[$index];

            return new NextHandler($item, $next);
        }

        return new ErrorHandler;
    }
}
