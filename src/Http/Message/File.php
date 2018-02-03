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
     * @param string  $file
     * @param string  $name
     * @param integer $error
     */
    public function __construct($file, $name, $error = UPLOAD_ERR_OK)
    {
        $this->error = $error;

        $this->file = $file;

        $this->name = $name;

        $this->size = filesize($file);

        $this->type = mime_content_type($file);
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
            list($files[$name], $items) = array($file, array());

            if (isset($file['name']) === true) {
                foreach ($file['name'] as $key => $value) {
                    $tmp = $file['tmp_name'][$key];

                    $text = $file['name'][$key];

                    $error = $file['error'][$key];

                    $items[] = new File($tmp, $text, $error);
                }

                $files[$name] = $items;
            }
        }

        return $files;
    }
}
