<?php

namespace Zapheus\Http\Message;

/**
 * Request Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RequestInterface extends MessageInterface
{
    /**
     * Returns an array of attributes derived from the request.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function attributes();

    /**
     * Returns the cookies from the request.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function cookies();

    /**
     * Returns any parameters provided in the request body.
     *
     * @return null|array|object
     */
    public function data();

    /**
     * Returns normalized file upload data.
     *
     * @return \Zapheus\Http\Message\UploadedFileInterface[]
     */
    public function files();

    /**
     * Returns the HTTP method of the request.
     *
     * @return string
     */
    public function method();

    /**
     * Returns the query string arguments.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function query();

    /**
     * Returns server parameters.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function server();

    /**
     * Returns the message's request target.
     *
     * @return string
     */
    public function target();

    /**
     * Returns the URI instance.
     *
     * @return \Zapheus\Http\Message\Uri
     */
    public function uri();
}
