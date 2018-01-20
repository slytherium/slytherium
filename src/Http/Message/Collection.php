<?php

namespace Zapheus\Http\Message;

/**
 * Collection
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Collection
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * Initializes the collection instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns all of the data.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Checks if the specified key exists.
     *
     * @param  string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Returns the value from a specified key.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $exists = $this->has($key);

        $value = $default;

        $exists && $value = $this->data[$key];

        return $value;
    }

    /**
     * Sets a value of the specified key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }
}
