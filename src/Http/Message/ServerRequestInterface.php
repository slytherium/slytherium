<?php

namespace Zapheus\Http\Message;

/**
 * Server Request Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ServerRequestInterface extends RequestInterface
{
    /**
     * Retrieve a single derived request attribute.
     *
     * @param  string $name
     * @param  mixed  $default
     * @return mixed
     */
    public function getAttribute($name, $default = null);

    /**
     * Retrieve attributes derived from the request.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Retrieve cookies.
     *
     * @return array
     */
    public function getCookieParams();

    /**
     * Retrieve any parameters provided in the request body.
     *
     * @return null|array|object
     */
    public function getParsedBody();

    /**
     * Retrieve query string arguments.
     *
     * @return array
     */
    public function getQueryParams();

    /**
     * Retrieve normalized file upload data.
     *
     * @return array
     */
    public function getUploadedFiles();

    /**
     * Retrieve server parameters.
     *
     * @return array
     */
    public function getServerParams();

    /**
     * Return an instance with the specified derived request attribute.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return static
     */
    public function withAttribute($name, $value);

    /**
     * Return an instance with the specified cookies.
     *
     * @param  array $cookies
     * @return static
     */
    public function withCookieParams(array $cookies);

    /**
     * Return an instance with the specified body parameters.
     *
     * @param  null|array|object $data
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withParsedBody($data);

    /**
     * Return an instance with the specified query string arguments.
     *
     * @param  array $query
     * @return static
     */
    public function withQueryParams(array $query);

    /**
     * Create a new instance with the specified uploaded files.
     *
     * @param  array $uploadedFiles
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withUploadedFiles(array $uploadedFiles);

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * @param  string $name
     * @return static
     */
    public function withoutAttribute($name);
}
