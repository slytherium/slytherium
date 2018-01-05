<?php

namespace Zapheus\Routing;

/**
 * Router Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RouterInterface
{
    /**
     * Adds a new Route instance to the collection.
     *
     * @param  \Zapheus\Routing\Route $route
     * @return self
     */
    public function add(Route $route);

    /**
     * Returns a listing of routes.
     *
     * @return array
     */
    public function routes();
}
