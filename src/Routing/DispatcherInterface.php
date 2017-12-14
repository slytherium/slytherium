<?php

namespace Slytherium\Routing;

/**
 * Route Dispatcher Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface DispatcherInterface
{
    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Slytherium\Routing\ResolverInterface
     *
     * @throws \UnexpectedValueException
     */
    public function dispatch($method, $uri);
}
