<?php

namespace Slytherium\Provider\Illuminate;

use Illuminate\Container\Container as Illuminate;
use Slytherium\Container\ContainerInterface;

/**
 * Illuminate to Slytherium Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container extends Illuminate implements ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     */
    public function get($id)
    {
        return parent::get($id);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return parent::has($id);
    }
}
