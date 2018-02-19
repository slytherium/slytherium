<?php

namespace Zapheus\Routing;

use Zapheus\Container\ContainerInterface;

/**
 * Resolver Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ResolverInterface
{
    /**
     * Resolves the specified handler against a container instance.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @param  \Zapheus\Routing\RouteInterface       $route
     * @return mixed
     */
    public function resolve(ContainerInterface $container, RouteInterface $route);
}
