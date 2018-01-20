<?php

namespace Zapheus\Http\Message;

/**
 * Mutator
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Mutator
{
    /**
     * Sets a new item to an array property.
     *
     * @param  string  $name
     * @param  string  $key
     * @param  mixed   $value
     * @param  boolean $mutable
     * @return self
     */
    // public function push($name, $key, $value, $mutable = false)
    // {
    //     $new = $mutable ? $this : clone $this;

    //     $array = $new->$name;

    //     $array[$key][] = $value;

    //     $new->$name = $array;

    //     return $new;
    // }

    /**
     * Removes a key from an array property.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  boolean $mutable
     * @return self
     */
    // public function remove($name, $key, $mutable = false)
    // {
    //     $new = $mutable ? $this : clone $this;

    //     $array = $new->$name;

    //     unset($array[$key]);

    //     $new->$name = $array;

    //     return $new;
    // }

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
        $new = $mutable ? $this : clone $this;

        $new->$name = $value;

        return $new;
    }
}
