<?php

namespace Slytherium\Http\Message;

/**
 * Uploaded File Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface UploadedFileInterface
{
    /**
     * Retrieve the filename sent by the client.
     *
     * @return string|null
     */
    public function getClientFilename();

    /**
     * Retrieve the media type sent by the client.
     *
     * @return string|null
     */
    public function getClientMediaType();

    /**
     * Retrieve the error associated with the uploaded file.
     *
     * @return integer
     */
    public function getError();

    /**
     * Retrieve a stream representing the uploaded file.
     *
     * @return \Slytherium\Http\Message\StreamInterface
     *
     * @throws \RuntimeException
     */
    public function getStream();

    /**
     * Retrieve the file size.
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
