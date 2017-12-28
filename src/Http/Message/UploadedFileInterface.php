<?php

namespace Zapheus\Http\Message;

/**
 * Uploaded File Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface UploadedFileInterface
{
    /**
     * Retrieves the filename sent by the client.
     *
     * @return string|null
     */
    public function getClientFilename();

    /**
     * Retrieves the media type sent by the client.
     *
     * @return string|null
     */
    public function getClientMediaType();

    /**
     * Retrieves the error associated with the uploaded file.
     *
     * @return integer
     */
    public function getError();

    /**
     * Retrieves a stream representing the uploaded file.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     *
     * @throws \RuntimeException
     */
    public function getStream();

    /**
     * Retrieves the file size.
     *
     * @return integer|null
     */
    public function getSize();

    /**
     * Move the uploaded file to a new location.
     *
     * @param  string $target
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function moveTo($target);
}
