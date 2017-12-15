<?php

namespace Slytherium\Provider\Slytherin;

use Rougin\Slytherin\Container\ContainerInterface;
use Slytherium\Container\WritableInterface;

/**
 * Slytherium to Slytherin Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * @var \Slytherium\Container\WritableInterface
     */
    protected $container;

    /**
     * Initializes the container instance.
     *
     * @param \Slytherium\Container\WritableInterface $container
     */
    public function __construct(WritableInterface $container)
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
