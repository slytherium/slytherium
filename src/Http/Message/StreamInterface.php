<?php

namespace Zapheus\Http\Message;

/**
 * Stream Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface StreamInterface
{
    /**
     * Closes the stream and any underlying resources.
     *
     * @return void
     */
    public function close();

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function contents();

    /**
     * Separates any underlying resources from the stream.
     *
     * @return resource|null
     */
    public function detach();

    /**
     * Returns true if the stream is at the end of the stream.
     *
     * @return boolean
     */
    public function eof();

    /**
     * Returns stream metadata as an associative array or retrieve a specific key.
     *
     * @param  string $key
     * @return array|mixed|null
     */
    public function metadata($key = null);

    /**
     * Reads data from the stream.
     *
     * @param  integer $length
     * @return string
     *
     * @throws \RuntimeException
     */
    public function read($length);

    /**
     * Returns whether or not the stream is readable.
     *
     * @return boolean
     */
    public function readable();

    /**
     * Seeks to the beginning of the stream.
     *
     * @throws \RuntimeException
     */
    public function rewind();

    /**
     * Seeks to a position in the stream.
     *
     * @param integer $offset
     * @param integer $whence
     *
     * @throws \RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET);

    /**
     * Returns whether or not the stream is seekable.
     *
     * @return boolean
     */
    public function seekable();

    /**
     * Returns the size of the stream if known.
     *
     * @return integer|null
     */
    public function size();

    /**
     * Returns the current position of the file read/write pointer.
     *
     * @return integer
     *
     * @throws \RuntimeException
     */
    public function tell();

    /**
     * Returns whether or not the stream is writable.
     *
     * @return boolean
     */
    public function writable();

    /**
     * Writes data to the stream.
     *
     * @param  string $string
     * @return integer
     *
     * @throws \RuntimeException
     */
    public function write($string);
}
