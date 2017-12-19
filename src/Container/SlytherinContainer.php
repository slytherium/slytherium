<?php

namespace Slytherium\Container;

use Rougin\Slytherin\Container\ContainerInterface as SlytherinContainerInterface;

/**
 * Slytherin to Slytherium Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinContainer implements ContainerInterface
{
    /**
     * @var \Rougin\Slytherin\Container\ContainerInterface
     */
    protected $container;

    /**
     * Initializes the container instance.
     *
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     */
    public function __construct(SlytherinContainerInterface $container)
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
}