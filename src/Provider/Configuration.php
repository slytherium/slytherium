<?php

namespace Slytherium\Provider;

/**
 * Configuration
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * Initializes the configuration instance.
     *
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $this->dotify($data);
    }

    /**
     * Returns the value from the specified key.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->offsetGet($key) ?: $default;
    }

    /**
     * Loads the configuration from a specified file or directory.
     *
     * @param  string  $path
     * @param  boolean $directory
     * @param  array   $data
     * @return self
     */
    public function load($path, $directory = false, $data = array())
    {
        $items = $directory ? glob($path . '/**/*.php') : array($path);

        foreach ((array) $items as $configuration) {
            $name = basename($configuration, '.php');

            $data[$name] = require $configuration;
        }

        $this->data = array_merge($this->data, $this->dotify($data));

        return $this;
    }

    /**
     * Checks whether an offset exists.
     *
     * @param  mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Returns the value at specified offset.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Unsets an offset.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Sets the value to the specified key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Converts the data into dot notation values.
     *
     * @param  array $data
     * @param  array $result
     * @return array
     */
    protected function dotify(array $data, $result = array())
    {
        $array = new \RecursiveArrayIterator($data);

        $iterator = new \RecursiveIteratorIterator($array);

        foreach ($iterator as $value) {
            $keys = array();

            foreach (range(0, $iterator->getDepth()) as $depth) {
                $subiterator = $iterator->getSubIterator($depth);

                array_push($keys, $subiterator->key());
            }

            $result[strtolower(join('.', $keys))] = $value;
        }

        return $result;
    }
}
