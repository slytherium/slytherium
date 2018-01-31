<?php

namespace Zapheus\Container;

/**
 * Container
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container implements WritableInterface
{
    /**
     * @var \Zapheus\Container\ContainerInterface|null
     */
    protected $delegate = null;

    /**
     * @var array
     */
    protected $objects = array();

    /**
     * Initializes the container instance.
     *
     * @param mixed[] $objects
     */
    public function __construct(array $objects = array())
    {
        $this->objects = $objects;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Zapheus\Container\NotFoundException
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            $message = 'Alias (%s) is not being managed by the container';

            throw new NotFoundException(sprintf($message, $id));
        }

        return $this->objects[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->objects[$id]);
    }

    /**
     * Sets a new instance to the container.
     *
     * @param  string $id
     * @param  mixed  $concrete
     * @return self
     *
     * @throws \Zapheus\Container\ContainerException
     */
    public function set($id, $concrete)
    {
        if (is_object($concrete) === false) {
            $message = 'Alias (%s) is not an object';

            $message = sprintf($message, $id);

            throw new ContainerException($message);
        }

        $this->objects[$id] = $concrete;

        return $this;
    }
}
