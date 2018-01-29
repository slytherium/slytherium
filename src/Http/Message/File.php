<?php

namespace Zapheus\Http\Message;

/**
 * File
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class File implements FileInterface
{
    /**
     * @var integer
     */
    protected $error;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer|null
     */
    protected $size;

    /**
     * @var string
     */
    protected $type;

    /**
     * Initializes the uploaded file instance.
     *
     * @param string       $file
     * @param integer|null $size
     * @param integer      $error
     * @param string|null  $name
     * @param string|null  $type
     */
    public function __construct($file, $size = null, $error = UPLOAD_ERR_OK, $name = null, $type = null)
    {
        $this->error = $error;

        $this->file = $file;

        $this->name = $name;

        $this->size = $size;

        $this->type = $type;
    }

    /**
     * Returns the error associated with the uploaded file.
     *
     * @return integer
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Move the uploaded file to a new location.
     *
     * @param string $target
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function move($target)
    {
        rename($this->file, $target);
    }

    /**
     * Returns the filename sent by the client.
     *
     * @return string|null
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the file size.
     *
     * @return integer|null
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * Returns a stream representing the uploaded file.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     *
     * @throws \RuntimeException
     */
    public function stream()
    {
        $stream = fopen($this->file, 'r');

        $stream = $stream === false ? null : $stream;

        return new Stream($stream);
    }

    /**
     * Returns the media type sent by the client.
     *
     * @return string|null
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Parses the $_FILES into multiple \File instances.
     *
     * @param  array $uploaded
     * @param  array $files
     * @return \Zapheus\Http\Message\FileInterface[]
     */
    public static function normalize(array $uploaded, $files = array())
    {
        foreach ((array) $uploaded as $name => $file) {
            $files[$name] = array();

            $array = self::arrayify($file);

            isset($file[0]) || $file = self::convert($file, $array);

            $files[$name] = $file;
        }

        return $files;
    }

    /**
     * Converts each value as array.
     *
     * @param  array $item
     * @return array
     */
    protected static function arrayify(array $item)
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
     * Converts the specified $_FILES array to a \File instance.
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
                $file[$i][$key] = $current[$key][$i];
            }

            $error = $file[$i]['error'];
            $original = $file[$i]['name'];
            $size = $file[$i]['size'];
            $tmp = $file[$i]['tmp_name'];
            $type = $file[$i]['type'];

            $items[$i] = new File($tmp, $size, $error, $original, $type);
        }

        return $items;
    }
}
