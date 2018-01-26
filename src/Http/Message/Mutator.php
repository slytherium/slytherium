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
     * Sets a value to a specified property.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  boolean $mutable
     * @return self
     */
    public function set($name, $value, $mutable = false)
    {
        $new = clone $this;

        $mutable || $new = $this;

        $new->$name = $value;

        return $new;
    }
}
