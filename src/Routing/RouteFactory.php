<?php

namespace Zapheus\Routing;

use Zapheus\Http\Server\MiddlewareInterface;

class RouteFactory
{
    /**
     * @var array|callable|string
     */
    protected $handler;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $middlewares = array();

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var string
     */
    protected $uri;

    public function __construct(RouteInterface $route = null)
    {
        if ($route === null)
        {
            return;
        }

        $this->handler = $route->handler();

        $this->method = $route->method();

        $this->middlewares = $route->middlewares();

        $this->parameters = $route->parameters();

        $this->uri = $route->uri();
    }

    public function handler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    public function make()
    {
        return new Route($this->method, $this->uri, $this->handler, $this->middlewares, $this->parameters);
    }

    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    public function middleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function middlewares(array $middlewares)
    {
        foreach ($middlewares as $middleware)
        {
            $this->middleware($middleware);
        }

        return $this;
    }

    public function parameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function uri($uri)
    {
        $this->uri = $uri;

        return $this;
    }
}
