<?php

namespace Slytherium\Provider\Slytherin;

use Slytherium\Container\WritableInterface;
use Rougin\Slytherin\Container\ContainerInterface;

/**
 * Slytherin to Slytherium Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BridgeContainer implements WritableInterface
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
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Rougin\Slytherin\Container\Exception\NotFoundException
     * @throws \Rougin\Slytherin\Container\Exception\ContainerException
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
     * @return self
     *
     * @throws \Slytherium\Container\ContainerException
     */
    public function set($id, $concrete)
    {
        return $this->container->set($id, $concrete);
    }
}
