<?php

namespace Slytherium\Container;

/**
 * Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container implements WritableInterface
{
    /**
     * @var \Slytherium\Container\ContainerInterface|null
     */
    protected $delegate = null;

    /**
     * @var array
     */
    protected $objects = array();

    /**
     * @param \Slytherium\Container\ContainerInterface|null $delegate
     */
    public function __construct(ContainerInterface $delegate = null)
    {
        is_null($delegate) || $this->delegate($delegate);
    }

    /**
     * Delegates a new container.
     *
     * @param  \Slytherium\Container\ContainerInterface $container
     * @return self
     */
    public function delegate($container)
    {
        $this->delegate = $container;

        return $this;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Slytherium\Container\NotFoundException
     */
    public function get($id)
    {
        $this->has($id) ?: $this->depute($id);

        if (isset($this->objects[$id]) === false) {
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
     * @throws \Slytherium\Container\ContainerException
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

    /**
     * Finds the entry from a delegate container if its available.
     *
     * @param  string $id
     * @return boolean
     */
    protected function depute($id)
    {
        $entry = $this->delegate ? $this->delegate->get($id) : null;

        return ! is_null($entry) && $this->objects[$id] = $entry;
    }
}
