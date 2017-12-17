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
        $this->data = $data;
    }

    /**
     * Returns all the stored configurations.
     *
     * @param  boolean $dotify
     * @return array
     */
    public function all($dotify = false)
    {
        return $dotify ? $this->dotify($this->data) : $this->data;
    }

    /**
     * Returns the value from the specified key.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @param  boolean    $dotify
     * @return mixed
     */
    public function get($key, $default = null, $dotify = false)
    {
        $items = $this->offsetGet($key) ?: $default;

        return $dotify ? $this->dotify($items) : $items;
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

            $name = strtolower($name);

            $data[$name] = require $configuration;
        }

        $this->data = array_merge($this->data, $data);

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
        return $this->offsetGet($offset) !== null;
    }

    /**
     * Returns the value at specified offset.
     *
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $keys = array_filter(explode('.', $offset));

        $length = count($keys);

        $data = $this->data;

        for ($i = 0; $i < $length; $i++) {
            $index = $keys[$i];

            $data = &$data[$index];
        }

        return $data;
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
        $keys = array_filter(explode('.', $offset));

        $this->save($keys, $this->data, $value);
    }

    /**
     * Unsets an offset.
     *
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        $keys = array_filter(explode('.', $offset));

        unset($this->data[$keys[0]]);
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

    /**
     * Saves the specified key in the list of data.
     *
     * @param  array  &$keys
     * @param  array  &$data
     * @param  mixed  $value
     * @return mixed
     */
    protected function save(array &$keys, &$data, $value)
    {
        $key = array_shift($keys);

        if (empty($keys)) {
            $data[$key] = $value;

            return $data[$key];
        }

        isset($data[$key]) || $data[$key] = array();

        return $this->save($keys, $data[$key], $value);
    }
}
