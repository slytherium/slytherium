<?php

namespace Zapheus\Http\Message;

/**
 * Request
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Request extends Message implements RequestInterface
{
    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var array
     */
    protected $cookies = array();

    /**
     * @var array|null|object
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $files = array();

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var array
     */
    protected $queries = array();

    /**
     * @var array
     */
    protected $server = array();

    /**
     * @var string
     */
    protected $target = '/';

    /**
     * @var \Zapheus\Http\Message\UriInterface
     */
    protected $uri;

    /**
     * Initializes the request instance.
     *
     * @param string                                     $method
     * @param string                                     $target
     * @param array                                      $server
     * @param array                                      $cookies
     * @param array|null|object                          $data
     * @param \Zapheus\Http\Message\FileInterface[]      $files
     * @param array                                      $queries
     * @param array                                      $attributes
     * @param \Zapheus\Http\Message\UriInterface|null    $uri
     * @param array                                      $headers
     * @param \Zapheus\Http\Message\StreamInterface|null $stream
     * @param string                                     $version
     */
    public function __construct($method, $target, array $server = array(), array $cookies = array(), array $data = array(), array $files = array(), array $queries = array(), array $attributes = array(), UriInterface $uri = null, array $headers = array(), StreamInterface $stream = null, $version = '1.1')
    {
        parent::__construct($headers, $stream, $version);

        $this->attributes = $attributes;

        $this->cookies = $cookies;

        $this->data = $data;

        $this->files = $files;

        $this->method = $method;

        $this->queries = $queries;

        $this->server = $server;

        $this->target = $target;

        $this->uri = $uri;
    }

    /**
     * Returns an instance with the specified derived request attribute.
     *
     * @param  string $name
     * @return mixed
     */
    public function attribute($name)
    {
        $exists = isset($this->attributes[$name]);

        return $exists ? $this->attributes[$name] : null;
    }

    /**
     * Returns an array of attributes derived from the request.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;

        // getAttributes
        // withAttribute
        // withoutAttribute
    }

    /**
     * Returns the specified cookie from request.
     *
     * @param  string $name
     * @return array
     */
    public function cookie($name)
    {
        $exists = isset($this->cookies[$name]);

        return $exists ? $this->cookies[$name] : null;
    }

    /**
     * Returns the cookies from the request.
     *
     * @return array
     */
    public function cookies()
    {
        return $this->cookies;

        // getCookieParams
        // withCookieParams
    }

    /**
     * Returns any parameters provided in the request body.
     *
     * @return array|null|object
     */
    public function data()
    {
        return $this->data;

        // getParsedBody
        // withParsedBody
    }

    /**
     * Returns normalized file upload data.
     *
     * @return \Zapheus\Http\Message\UploadedFile[]
     */
    public function files()
    {
        return $this->files;

        // getUploadedFiles
        // withUploadedFiles
    }

    /**
     * Returns the HTTP method of the request.
     *
     * @return string
     */
    public function method()
    {
        return $this->method;

        // getMethod
        // withMethod
    }

    /**
     * Returns the query string arguments.
     *
     * @return array
     */
    public function queries()
    {
        return $this->queries;

        // getQueryParams
        // withQueryParams
    }

    /**
     * Returns the specified query string argument.
     *
     * @param  string $name
     * @return array
     */
    public function query($name)
    {
        $exists = isset($this->queries[$name]);

        return $exists ? $this->queries[$name] : null;
    }

    /**
     * Returns the server parameter/s.
     *
     * @param  string|null $name
     * @return array
     */
    public function server($name = null)
    {
        $value = $name === null ? $this->server : null;

        $server = (array) $this->server;

        isset($server[$name]) && $value = $server[$name];

        return $value;

        // getServerParams
    }

    /**
     * Returns the message's request target.
     *
     * @return string
     */
    public function target()
    {
        return $this->target;

        // getRequestTarget
        // withRequestTarget
    }

    /**
     * Returns the URI instance.
     *
     * @return \Zapheus\Http\Message\UriInterface
     */
    public function uri()
    {
        return $this->uri;

        // getUri
        // withUri
    }
}
