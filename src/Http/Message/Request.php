<?php

namespace Zapheus\Http\Message;

/**
 * Request
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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
     * @var array
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
    protected $query = array();

    /**
     * @var array
     */
    protected $server = array();

    /**
     * @var string
     */
    protected $target = '/';

    /**
     * Initializes the request instance.
     *
     * @param array $server
     * @param array $cookies
     * @param array $data
     * @param array $files
     * @param array $query
     * @param array $attributes
     */
    public function __construct(array $server, array $cookies = array(), array $data = array(), array $files = array(), array $query = array(), array $attributes = array())
    {
        parent::__construct(Message::request($server));

        $this->attributes = $attributes;

        $this->cookies = $cookies;

        $this->data = $data;

        $this->files = File::normalize($files);

        $this->method = $server['REQUEST_METHOD'];

        $this->query = $query;

        $this->server = $server;

        $this->target = $server['REQUEST_URI'];
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

        // getAttribute
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
     * @return array
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
    public function query()
    {
        return $this->query;

        // getQueryParams
        // withQueryParams
    }

    /**
     * Returns server parameters.
     *
     * @return array
     */
    public function server()
    {
        return $this->server;

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
}
