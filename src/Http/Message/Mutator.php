<?php

namespace Zapheus\Http\Message;

/**
 * Mutator
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Mutator implements MutatorInterface
{
    /**
     * Pushes a new value into an immutable property.
     *
     * @param  string      $name
     * @param  mixed       $value
     * @param  string|null $key
     * @return static
     */
    public function push($name, $value, $key = null)
    {
        $new = clone $this;

        $array = $new->$name;

        if ($key !== null) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }

        $new->$name = $array;

        return $new;
    }

    /**
     * Sets a property to a mutable instance.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     */
    public function set($name, $value)
    {
        $this->$name = $value;

        return $this;
    }

    /**
     * Sets a property to an immutable instance.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return static
     */
    public function with($name, $value)
    {
        $new = clone $this;

        $new->$name = $value;

        return $new;
    }
}
