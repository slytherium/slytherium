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
        $keys = (array) array_filter(explode('.', $key));

        list($items, $length) = array($this->data, count($keys));

        for ($i = 0; $i < $length; $i++) {
            $index = $keys[$i];

            $items = &$items[$index];
        }

        $items = $items !== null ? $items : $default;

        return $dotify ? $this->dotify((array) $items) : $items;
    }

    /**
     * Loads an array of values from a specified file or directory.
     *
     * @param  string $path
     * @return void
     */
    public function load($path)
    {
        list($data, $items) = array(array(), array($path));

        if (substr((string) $path, -4) !== '.php') {
            $directory = new \RecursiveDirectoryIterator($path);

            $iterator = new \RecursiveIteratorIterator($directory);

            $regex = new \RegexIterator($iterator, '/^.+\.php$/i', 1);

            $items = (array) array_keys(iterator_to_array($regex));
        }

        foreach ((array) $items as $item) {
            $name = $this->rename($item, $path);

            $data = require $item;

            $this->set((string) $name, $data);
        }
    }

    /**
     * Converts the data into dot notation values.
     *
     * @param  array  $data
     * @param  array  $result
     * @param  string $key
     * @return array
     */
    protected function dotify(array $data, $result = array(), $key = '')
    {
        foreach ((array) $data as $name => $value) {
            if (is_array($value) && empty($value) === false) {
                $text = (string) $key . (string) $name . '.';

                $item = $this->dotify($value, $result, $text);

                $result = array_merge($result, (array) $item);

                continue;
            }

            $result[$key . $name] = $value;
        }

        return $result;
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
        $keys = array_filter(explode('.', $key));

        $this->save($keys, $this->data, $value);

        return $this;
    }

    /**
     * Renames the item into a dot notation one.
     *
     * @param  string $item
     * @param  string $path
     * @return string
     */
    protected function rename($item, $path)
    {
        $name = (string) str_replace($path, '', $item);

        $name = str_replace(array('\\', '/'), '.', $name);

        $name === '' && $name = (string) $item;

        $regex = preg_replace('/^./i', '', $name);

        return basename(strtolower($regex), '.php');
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
