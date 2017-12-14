<?php

namespace Slytherium\Routing;

/**
 * Route Dispatcher
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var \Slytherium\Routing\RouterInterface
     */
    protected $router;

    /**
     * Initializes the dispatcher instance.
     *
     * @param \Slytherium\Routing\RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Slytherium\Routing\ResolverInterface
     *
     * @throws \UnexpectedValueException
     */
    public function dispatch($method, $uri)
    {
        if (($result = $this->match($method, $uri)) !== null) {
            list($matches, $handler) = $result;

            $filtered = array_filter(array_keys($matches), 'is_string');

            $values = array_intersect_key($matches, array_flip($filtered));

            return new Resolver($handler, $values);
        }

        $error = sprintf('Route "%s %s" not found', $method, $uri);

        throw new \UnexpectedValueException($error);
    }

    /**
     * Matches the route from the parsed URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return array|null
     */
    protected function match($method, $uri)
    {
        $result = null;

        foreach ((array) $this->router->routes() as $route) {
            $exists = preg_match($route->uri(true), $uri, $matches);

            $matched = $exists && $route->method() === $method;

            $matched && $result = array($matches, $route->handler());
        }

        return $result;
    }
}
