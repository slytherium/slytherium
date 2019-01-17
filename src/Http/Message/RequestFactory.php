<?php

namespace Zapheus\Http\Message;

class RequestFactory extends MessageFactory
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

    public function __construct(RequestInterface $request = null)
    {
        parent::__construct($request);

        if ($request === null)
        {
            return;
        }

        $this->attributes = $request->attributes();

        $this->cookies = $request->cookies();

        $this->data = $request->data();

        $this->files = $request->files();

        $this->method = $request->method();

        $this->queries = $request->queries();

        $this->server = $request->server();

        $this->target = $request->target();

        $this->uri = $request->uri();
    }

    public function attribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function cookie($key, $value)
    {
        $this->cookies[$key] = $value;

        return $this;
    }

    public function cookies(array $cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function files(array $files)
    {
        $this->files = $files;

        return $this;
    }

    public function make()
    {
        return new Request($this->method, $this->target, $this->server, $this->cookies, $this->data, $this->files, $this->queries, $this->attributes, $this->uri, $this->headers, $this->stream, $this->version);
    }

    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    public function queries(array $queries)
    {
        $this->queries = $queries;

        return $this;
    }

    public function query($name, $value)
    {
        $this->queries[$name] = $value;

        return $this;
    }

    public function server(array $server)
    {
        parent::server($server);

        $this->server = $server;

        $this->method = $server['REQUEST_METHOD'];

        $this->target = $server['REQUEST_URI'];

        $http = 'https://';

        if (isset($server['HTTPS']) && $server['HTTPS'] === 'off')
        {
            $http = 'http://';
        }

        $link = $http . $server['SERVER_NAME'];

        $port = $server['SERVER_PORT'] . $this->target;

        $this->uri = new Uri($link . ':' . $port);

        return $this;
    }

    public function target($target)
    {
        $this->target = $target;

        return $this;
    }

    public function uri(UriInterface $uri)
    {
        $this->uri = $uri;

        return $this;
    }
}
