<?php

namespace Zapheus\Routing;

/**
 * Route Dispatcher
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var \Zapheus\Routing\RouterInterface
     */
    protected $router;

    /**
     * Initializes the dispatcher instance.
     *
     * @param \Zapheus\Routing\RouterInterface $router
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
     * @return \Zapheus\Routing\ResolverInterface
     *
     * @throws \UnexpectedValueException
     */
    public function dispatch($method, $uri)
    {
        $uri = $uri[0] !== '/' ? '/' . $uri : $uri;

        if (($result = $this->match($method, $uri)) !== null) {
            list($matches, $handler) = (array) $result;

            $filtered = array_filter(array_keys($matches), 'is_string');

            $flipped = (array) array_flip($filtered);

            $values = array_intersect_key($matches, $flipped);

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
            $exists = preg_match($route->regex(), $uri, $matches);

            if ($exists === 1 && $route->method() === $method) {
                $result = array($matches, $route->handler());

                break; // Break because the needed route was found
            }
        }

        return $result;
    }
}
