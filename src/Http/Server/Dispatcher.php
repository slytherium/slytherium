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
            $middleware = $this->transform($item);

            $this->stack[] = $middleware;
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
        $this->stack[] = new LastMiddleware($handler);

        $response = $this->dispatch($request);

        unset($this->stack[count($this->stack) - 1]);

        return $response;
    }

    /**
     * Adds a new middleware to the stack.
     *
     * @param  mixed $item
     * @return self
     */
    public function pipe($item)
    {
        $item = $this->transform($item);

        $this->stack[] = $item;

        return $this;
    }

    /**
     * Transforms the specified input into a middleware.
     *
     * @param  mixed $item
     * @return \Slytherium\Http\Server\MiddlewareInterface
     */
    protected function transform($item)
    {
        is_string($item) && $item = new $item;

        is_callable($item) && $item = new ClosureMiddleware($item);

        return $item;
    }

    /**
     * Resolves the whole stack through its index.
     *
     * @param  integer $index
     * @return \Slytherium\Http\Server\HandlerInterface
     */
    protected function resolve($index)
    {
        if (isset($this->stack[$index]) === true) {
            $next = $this->resolve($index + 1);

            $item = $this->stack[$index];

            return new NextHandler($item, $next);
        }

        return new ErrorHandler;
    }
}
