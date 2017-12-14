<?php

namespace Slytherium\Container;

/**
 * Writable Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface WritableInterface extends ContainerInterface
{
    /**
     * Sets a new instance on the given entry to the container.
     *
     * @param  string $id
     * @param  mixed  $concrete
     * @return self
     *
     * @throws \Slytherium\Container\ContainerException
     */
    public function set($id, $concrete);
}
