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
     * @var array
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
     * Adds a new Route instance to the collection.
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
     * Checks if the router contains the specified HTTP method and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return boolean
     */
    public function has($method, $uri)
    {
        $results = array();

        foreach ($this->routes as $route) {
            $matched = preg_match($route->uri(true), $uri);

            $matched = $matched && $method === $route->method();

            $results[] = $matched;
        }

        return array_search(true, $results) !== false;
    }

    /**
     * Returns a listing of routes.
     *
     * @return array
     */
    public function routes()
    {
        return $this->routes;
    }

    /**
     * Adds a new Route instance in CONNECT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function connect($uri, $handler)
    {
        return $this->add(new Route('CONNECT', $uri, $handler));
    }

    /**
     * Adds a new Route instance in DELETE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function delete($uri, $handler)
    {
        return $this->add(new Route('DELETE', $uri, $handler));
    }

    /**
     * Adds a new Route instance in GET HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function get($uri, $handler)
    {
        return $this->add(new Route('GET', $uri, $handler));
    }

    /**
     * Adds a new Route instance in HEAD HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function head($uri, $handler)
    {
        return $this->add(new Route('HEAD', $uri, $handler));
    }

    /**
     * Adds a new Route instance in OPTIONS HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function options($uri, $handler)
    {
        return $this->add(new Route('OPTIONS', $uri, $handler));
    }

    /**
     * Adds a new Route instance in PATCH HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function patch($uri, $handler)
    {
        return $this->add(new Route('PATCH', $uri, $handler));
    }

    /**
     * Adds a new Route instance in POST HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function post($uri, $handler)
    {
        return $this->add(new Route('POST', $uri, $handler));
    }

    /**
     * Adds a new Route instance in PURGE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function purge($uri, $handler)
    {
        return $this->add(new Route('PURGE', $uri, $handler));
    }

    /**
     * Adds a new Route instance in PUT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function put($uri, $handler)
    {
        return $this->add(new Route('PUT', $uri, $handler));
    }

    /**
     * Adds a new Route instance in TRACE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function trace($uri, $handler)
    {
        return $this->add(new Route('TRACE', $uri, $handler));
    }
}
