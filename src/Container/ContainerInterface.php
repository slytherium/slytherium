<?php

namespace Zapheus\Container;

/**
 * Container Interface
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Zapheus\Container\Exception\NotFoundException
     * @throws \Zapheus\Container\Exception\ContainerException
     */
    public function get($id);

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id);
}
