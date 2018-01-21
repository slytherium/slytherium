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
        return new Stream(fopen($this->file, 'r'));
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
}
