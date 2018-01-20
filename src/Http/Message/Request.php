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
     * @var \Zapheus\Http\Message\Collection
     */
    protected $attributes;

    /**
     * @var \Zapheus\Http\Message\Collection
     */
    protected $cookies;

    /**
     * @var array|null|object
     */
    protected $data;

    /**
     * @var array
     */
    protected $files = array();

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var \Zapheus\Http\Message\Collection
     */
    protected $query;

    /**
     * @var \Zapheus\Http\Message\Collection
     */
    protected $server;

    /**
     * @var string
     */
    protected $target = '/';

    /**
     * @var \Zapheus\Http\Message\Uri
     */
    protected $uri;

    /**
     * Initializes the request instance.
     *
     * @param array      $server
     * @param array      $cookies
     * @param array|null $data
     * @param array      $files
     * @param array      $query
     */
    public function __construct(array $server, array $cookies = array(), $data = null, array $files = array(), array $query = array(), array $attributes = array())
    {
        isset($server['HTTPS']) || $server['HTTPS'] = 'off';

        parent::__construct($this->convert($server));

        $this->attributes = new Collection($attributes);

        $this->cookies = new Collection($cookies);

        $this->data = $data;

        $this->files = $files;

        $this->method = $server['REQUEST_METHOD'];

        $this->query = new Collection($query);

        $this->server = new Collection($server);

        $this->target = $server['REQUEST_URI'];

        $this->uri = $this->generate($server);
    }

    /**
     * Returns an array of attributes derived from the request.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function attributes()
    {
        return $this->attributes;

        // getAttributes
        // getAttribute
        // withAttribute
        // withoutAttribute
    }

    /**
     * Returns the cookies from the request.
     *
     * @return \Zapheus\Http\Message\Collection
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
     * @return null|array|object
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
     * @return \Zapheus\Http\Message\UploadedFileInterface[]
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
     * @return \Zapheus\Http\Message\Collection
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
     * @return \Zapheus\Http\Message\Collection
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

    /**
     * Returns the URI instance.
     *
     * @return \Zapheus\Http\Message\Uri
     */
    public function uri()
    {
        return $this->uri;

        // getUri
        // withUri
    }

    /**
     * Converts $_SERVER parameters to message header values.
     *
     * @param  array $server
     * @return array
     */
    protected function convert(array $server)
    {
        $headers = array();

        foreach ((array) $server as $key => $value) {
            $http = strpos($key, 'HTTP_') === 0;

            $string = strtolower(substr($key, 5));

            $key = str_replace('_', '-', $string);

            $http && $headers[$key] = $value;
        }

        return $headers;
    }

    /**
     * Generates an UriInterface based from server values.
     *
     * @param  array $server
     * @return \Zapheus\Http\Message\UriInterface
     */
    protected function generate(array $server)
    {
        $http = $server['HTTPS'] === 'off' ? 'http' : 'https';

        list($name, $port) = array('localhost', 8000);

        isset($server['SERVER_NAME']) && $name = isset($server['SERVER_NAME']);

        isset($server['SERVER_PORT']) && $port = isset($server['SERVER_PORT']);

        return new Uri($http . '://' . $name . $port . $this->target);
    }
}
