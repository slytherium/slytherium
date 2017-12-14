<?php

namespace Slytherium\Routing;

use Slytherium\Container\ContainerInterface;

/**
 * Resolver Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ResolverInterface
{
    /**
     * Resolves the specified handler against a container instance.
     *
     * @param  \Slytherium\Container\ContainerInterface $container
     * @return mixed
     */
    public function resolve(ContainerInterface $container);

    /**
     * Returns the dispatched result.
     *
     * @return array
     */
    public function result();
}
