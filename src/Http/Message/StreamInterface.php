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
     * Reads all data from the stream into a string, from the beginning to end.
     *
     * @return string
     */
    public function __toString();

    /**
     * Closes the stream and any underlying resources.
     *
     * @return void
     */
    public function close();

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
     * Returns the remaining contents in a string
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getContents();

    /**
     * Get stream metadata as an associative array or retrieve a specific key.
     *
     * @param  string $key
     * @return array|mixed|null
     */
    public function getMetadata($key = null);

    /**
     * Get the size of the stream if known.
     *
     * @return integer|null
     */
    public function getSize();

    /**
     * Returns whether or not the stream is readable.
     *
     * @return boolean
     */
    public function isReadable();

    /**
     * Returns whether or not the stream is seekable.
     *
     * @return bool
     */
    public function isSeekable();

    /**
     * Returns whether or not the stream is writable.
     *
     * @return boolean
     */
    public function isWritable();

    /**
     * Read data from the stream.
     *
     * @param  integer $length
     * @return string
     *
     * @throws \RuntimeException
     */
    public function read($length);

    /**
     * Seek to the beginning of the stream.
     *
     * @throws \RuntimeException
     */
    public function rewind();

    /**
     * Seek to a position in the stream.
     *
     * @param  integer $offset
     * @param  integer $whence
     *
     * @throws \RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET);

    /**
     * Returns the current position of the file read/write pointer
     *
     * @return integer
     *
     * @throws \RuntimeException on error.
     */
    public function tell();

    /**
     * Write data to the stream.
     *
     * @param  string $string
     * @return integer
     *
     * @throws \RuntimeException
     */
    public function write($string);
}
