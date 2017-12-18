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
            $new = array($value);

            $array[$key] = $new;
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
            $files[$name] = array();

            if (isset($file[0]) === false) {
                is_array($file['name']) || $file = self::arrayify($file);

                $count = count($file['name']);

                $files = self::convert($files, $file, $name, $count);

                continue;
            }

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
     * @param  array   $files
     * @param  array   $current
     * @param  string  $name
     * @param  integer $count
     * @return array
     */
    protected static function convert($files, $current, $name, $count)
    {
        for ($i = 0; $i < $count; $i++) {
            foreach (array_keys($current) as $key) {
                $item = $current[$key][$i];

                $files[$name][$i][$key] = $item;
            }

            $error = $files[$name][$i]['error'];
            $original = $files[$name][$i]['name'];
            $size = $files[$name][$i]['size'];
            $tmp = $files[$name][$i]['tmp_name'];
            $type = $files[$name][$i]['type'];

            $files[$name][$i] = new UploadedFile($tmp, $size, $error, $original, $type);
        }

        return $files;
    }
}