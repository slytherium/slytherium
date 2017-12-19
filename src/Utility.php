<?php

namespace Slytherium;

use Slytherium\Http\Message\UploadedFile;
use Slytherium\Http\Message\Uri;

/**
 * Utility
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Utility
{
    /**
     * Converts each value as array.
     *
     * @param  array $item
     * @return array
     */
    public static function arrayify(array $item)
    {
        $array = array();

        foreach ($item as $key => $value) {
            $new = (array) array($value);

            isset($item['name']) && $value = $new;

            $array[$key] = $value;
        }

        return $array;
    }
    /**
     * Parses the $_FILES into multiple \UploadedFileInterface instances.
     *
     * @param  array $uploaded
     * @param  array $files
     * @return \Slytherium\Http\Message\UploadedFileInterface[]
     */
    public static function files(array $uploaded, $files = array())
    {
        foreach ((array) $uploaded as $name => $file) {
            $array = self::arrayify($file);

            $files[$name] = array();

            isset($file[0]) || $file = self::convert($file, $array);

            $files[$name] = $file;
        }

        return $files;
    }

    /**
     * Generates a \Slytherium\Http\Message\UriInterface if it does not exists.
     *
     * @param  array                                      $server
     * @param  \Slytherium\Http\Message\UriInterface|null $uri
     * @return \Slytherium\Http\Message\UriInterface
     */
    public static function uri(array $server, $uri = null)
    {
        $secure = isset($server['HTTPS']) ? $server['HTTPS'] : 'off';

        $http = $secure === 'off' ? 'http' : 'https';

        $url = $http . '://' . $server['SERVER_NAME'];

        $url .= $server['SERVER_PORT'] . $server['REQUEST_URI'];

        return $uri === null ? new Uri($url) : $uri;
    }

    /**
     * Converts the data from $_FILES to multiple \UploadInterface instances.
     *
     * @param  array $file
     * @param  array $current
     * @return array
     */
    protected static function convert($file, $current)
    {
        list($count, $items) = array(count($file['name']), array());

        for ($i = 0; $i < (integer) $count; $i++) {
            foreach (array_keys($current) as $key) {
                $item = $current[$key][$i];

                $file[$i][$key] = $item;
            }

            $error = $file[$i]['error'];
            $original = $file[$i]['name'];
            $size = $file[$i]['size'];
            $tmp = $file[$i]['tmp_name'];
            $type = $file[$i]['type'];

            $items[$i] = new UploadedFile($tmp, $size, $error, $original, $type);
        }

        return $items;
    }
}