<?php

namespace Zapheus\Provider;

/**
 * Configuration
 *
 * @package Zapheus
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
        $result = $this->offsetGet($key);

        $items = $result !== null ? $result : $default;

        $exists = is_array($items) && $dotify === true;

        return $exists ? $this->dotify($items) : $items;
    }

    /**
     * Loads the configuration from a specified file or directory.
     *
     * @param  string $path
     * @return void
     */
    public function load($path)
    {
        list($data, $items) = array(array(), array($path));

        if (substr($path, -4) !== '.php') {
            $folder = new \RecursiveDirectoryIterator($path);

            $items = new \RecursiveIteratorIterator($folder);

            $items = new \RegexIterator($items, '/^.+\.php$/i', 1);
        }

        foreach ($items as $item) {
            $item = is_array($item) ? $item[0] : $item;

            $name = basename((string) $item, '.php');

            $data[strtolower($name)] = require $item;
        }

        $this->data = array_merge($this->data, $data);
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
     * @param  array  $data
     * @param  array  $result
     * @param  string $key
     * @return array
     */
    protected function dotify(array $data, array $result = array(), $key = '')
    {
        foreach ((array) $data as $name => $value) {
            if (is_array($value) && empty($value) === false) {
                $new = $key . $name . '.';

                $array = $this->dotify($value, $result, $new);

                $result = array_merge($result, $array);

                continue;
            }

            $result[$key . $name] = $value;
        }

        return $result;
    }

    /**
     * Saves the specified key in the list of data.
     *
     * @param  array &$keys
     * @param  array &$data
     * @param  mixed $value
     * @return mixed
     */
    protected function save(array &$keys, &$data, $value)
    {
        $key = array_shift($keys);

        if (empty($keys) === false) {
            ! isset($data[$key]) && $data[$key] = array();

            return $this->save($keys, $data[$key], $value);
        }

        return $data[$key] = $value;
    }
}
