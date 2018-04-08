<?php

namespace Zapheus\Container;

/**
 * Composite Container
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CompositeContainer implements ContainerInterface
{
    /**
     * @var \Zapheus\Container\ContainerInterface[]
     */
    protected $containers = array();

    /**
     * Adds a container to the array of containers.
     *
     * @param \Zapheus\Container\ContainerInterface $container
     */
    public function add(ContainerInterface $container)
    {
        $this->containers[] = $container;

        return $this;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     */
    public function get($id)
    {
        $entry = null;

        foreach ($this->containers as $container) {
            $exists = $container->has($id) === true;

            $exists && $entry = $container->get($id);
        }

        if ($entry === null) {
            $message = 'Alias (%s) is not being managed by the container';

            throw new NotFoundException((string) sprintf($message, $id));
        }

        return $entry;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        $result = false;

        foreach ($this->containers as $container) {
            $contains = $container->has($id) === true;

            $contains && ! $result && $result = true;
        }

        return $result;
    }
}
