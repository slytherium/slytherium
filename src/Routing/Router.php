<?php

namespace Zapheus\Routing;

/**
 * Router
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @var \Zapheus\Routing\Route[]
     */
    protected $routes = array();

    /**
     * Initializes the router instance.
     *
     * @param \Zapheus\Routing\Route[] $routes
     */
    public function __construct(array $routes = array())
    {
        $this->routes = $routes;
    }

    /**
     * Adds a new route instance to the collection.
     *
     * @param  \Zapheus\Routing\Route $route
     * @return self
     */
    public function add(Route $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * Adds a new route instance in CONNECT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function connect($uri, $handler)
    {
        return $this->add($this->route('CONNECT', $uri, $handler));
    }

    /**
     * Adds a new route instance in DELETE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function delete($uri, $handler)
    {
        return $this->add($this->route('DELETE', $uri, $handler));
    }

    /**
     * Adds a new route instance in GET HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function get($uri, $handler)
    {
        return $this->add($this->route('GET', $uri, $handler));
    }

    /**
     * Checks if the router contains the specified route.
     *
     * @param  \Zapheus\Routing\Route $route
     * @return boolean
     */
    public function has(Route $route)
    {
        return array_search($route, $this->routes) !== false;
    }

    /**
     * Adds a new route instance in HEAD HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function head($uri, $handler)
    {
        return $this->add($this->route('HEAD', $uri, $handler));
    }

    /**
     * Adds a new route instance in OPTIONS HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function options($uri, $handler)
    {
        return $this->add($this->route('OPTIONS', $uri, $handler));
    }

    /**
     * Adds a new route instance in PATCH HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function patch($uri, $handler)
    {
        return $this->add($this->route('PATCH', $uri, $handler));
    }

    /**
     * Adds a new route instance in POST HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function post($uri, $handler)
    {
        return $this->add($this->route('POST', $uri, $handler));
    }

    /**
     * Adds a new route instance in PURGE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function purge($uri, $handler)
    {
        return $this->add($this->route('PURGE', $uri, $handler));
    }

    /**
     * Adds a new route instance in PUT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function put($uri, $handler)
    {
        return $this->add($this->route('PUT', $uri, $handler));
    }

    /**
     * Returns an array of routes.
     *
     * @return \Zapheus\Routing\Route[]
     */
    public function routes()
    {
        return $this->routes;
    }

    /**
     * Adds a new route instance in TRACE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function trace($uri, $handler)
    {
        return $this->add($this->route('TRACE', $uri, $handler));
    }

    /**
     * Prepares a new route instance.
     *
     * @param  string $method
     * @param  string $uri
     * @param  string $handler
     * @return \Zapheus\Routing\Route
     */
    protected function route($method, $uri, $handler)
    {
        if (is_string($handler) === true) {
            $namespace = $this->namespace;

            $namespace !== '' && $namespace .= '\\';

            $handler = $namespace . $handler;
        }

        return new Route($method, $uri, $handler);
    }
}
