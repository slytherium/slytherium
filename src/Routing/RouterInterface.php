<?php

namespace Slytherium\Routing;

/**
 * Router Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RouterInterface
{
    /**
     * Adds a new Route instance to the collection.
     *
     * @param  \Slytherium\Routing\Route $route
     * @return self
     */
    public function add(Route $route);

    /**
     * Checks if the router contains the specified HTTP method and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return boolean
     */
    public function has($method, $uri);

    /**
     * Returns a listing of routes.
     *
     * @return array
     */
    public function routes();
}
