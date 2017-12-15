<?php

namespace Slytherium\Provider\Common;

/**
 * Common Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container
{
    /**
     * @var mixed
     */
    protected $container;

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Sets a new instance on the given entry to the container.
     *
     * @param  string $id
     * @param  mixed  $concrete
     * @return mixed
     */
    public function set($id, $concrete)
    {
        return $this->container->set($id, $concrete);
    }
}
