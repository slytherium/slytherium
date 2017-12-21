<?php

namespace Zapheus\Container;

use Illuminate\Container\Container as BaseContainer;

/**
 * Illuminate to Zapheus Container
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateContainer implements ContainerInterface
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Initializes the container instance.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(BaseContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->make($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return $this->container->bound($id);
    }
}
