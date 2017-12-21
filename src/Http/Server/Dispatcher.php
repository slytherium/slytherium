<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Middleware Dispatcher
 *
 * @package Zapheus
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
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
    {
        $resolved = $this->resolve(0);

        return $resolved->handle($request);
    }

    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface $handler
     * @return \Zapheus\Http\Message\ResponseInterface
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
     * @param  mixed $middleware
     * @return self
     */
    public function pipe($middleware)
    {
        $this->stack[] = $this->transform($middleware);

        return $this;
    }

    /**
     * Transforms the specified input into a middleware.
     *
     * @param  mixed $middleware
     * @return \Zapheus\Http\Server\MiddlewareInterface
     */
    protected function transform($middleware)
    {
        if (is_string($middleware) === true) {
            $middleware = new $middleware;
        } elseif (is_callable($middleware)) {
            $middleware = new ClosureMiddleware($middleware);
        }

        return $middleware;
    }

    /**
     * Resolves the whole stack through its index.
     *
     * @param  integer $index
     * @return \Zapheus\Http\Server\HandlerInterface
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
