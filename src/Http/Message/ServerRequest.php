<?php

namespace Zapheus\Http\Message;

/**
 * Server Request
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ServerRequest extends Request implements ServerRequestInterface
{
    /**
     * @var array
     */
    protected $server = array();

    /**
     * @var array
     */
    protected $cookies = array();

    /**
     * @var array
     */
    protected $query = array();

    /**
     * @var array
     */
    protected $uploaded = array();

    /**
     * @var array|null|object
     */
    protected $data;

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * Initializes the server request instance.
     *
     * @param array                                      $server
     * @param array                                      $cookies
     * @param array                                      $query
     * @param array                                      $uploaded
     * @param array|null                                 $data
     * @param array                                      $attributes
     * @param \Zapheus\Http\Message\UriInterface|null    $uri
     * @param \Zapheus\Http\Message\StreamInterface|null $body
     * @param array                                      $headers
     * @param string                                     $version
     */
    public function __construct(array $server, array $cookies = array(), array $query = array(), array $uploaded = array(), $data = null, array $attributes = array(), UriInterface $uri = null, StreamInterface $body = null, array $headers = array(), $version = '1.1')
    {
        $uri = $this->uri($server, $uri);

        parent::__construct($server['REQUEST_METHOD'], $server['REQUEST_URI'], $uri, $body, $headers, $version);

        $this->cookies = $cookies;

        $this->data = $data;

        $this->query = $query;

        $this->server = $server;

        $this->uploaded = $this->files($uploaded);
    }

    /**
     * Retrieves a single derived request attribute.
     *
     * @param  string $name
     * @param  mixed  $default
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Retrieve cookies.
     *
     * @return array
     */
    public function getCookieParams()
    {
        return $this->cookies;
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * @return null|array|object
     */
    public function getParsedBody()
    {
        return $this->data;
    }

    /**
     * Retrieve query string arguments.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->query;
    }

    /**
     * Retrieve server parameters.
     *
     * @return array
     */
    public function getServerParams()
    {
        return $this->server;
    }

    /**
     * Retrieve normalized file upload data.
     *
     * @return \Zapheus\Http\Message\UploadedFileInterface[]
     */
    public function getUploadedFiles()
    {
        return $this->uploaded;
    }

    /**
     * Returns an instance with the specified derived request attribute.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return static
     */
    public function withAttribute($name, $value)
    {
        $new = clone $this;

        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Returns an instance with the specified cookies.
     *
     * @param  array $cookies
     * @return static
     */
    public function withCookieParams(array $cookies)
    {
        $new = clone $this;

        $new->cookies = $cookies;

        return $new;
    }

    /**
     * Returns an instance with the specified body parameters.
     *
     * @param  null|array|object $data
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withParsedBody($data)
    {
        $new = clone $this;

        $new->data = $data;

        return $new;
    }

    /**
     * Returns an instance with the specified query string arguments.
     *
     * @param  array $query
     * @return static
     */
    public function withQueryParams(array $query)
    {
        $new = clone $this;

        $new->query = $query;

        return $new;
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * @param  \Zapheus\Http\Message\UploadedFileInterface[] $uploaded
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withUploadedFiles(array $uploaded)
    {
        $new = clone $this;

        $new->uploaded = $uploaded;

        return $new;
    }

    /**
     * Returns an instance that removes the specified derived request attribute.
     *
     * @param  string $name
     * @return static
     */
    public function withoutAttribute($name)
    {
        $new = clone $this;

        unset($new->attributes[$name]);

        return $new;
    }

    /**
     * Converts each value as array.
     *
     * @param  array $item
     * @return array
     */
    protected function arrayify(array $item)
    {
        $array = array();

        foreach ($item as $key => $value) {
            $new = (array) array($value);

            isset($item['name']) && $value = $new;

            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * Converts the data from $_FILES to multiple \UploadInterface instances.
     *
     * @param  array $file
     * @param  array $current
     * @return array
     */
    protected function convert($file, $current)
    {
        list($count, $items) = array(count($file['name']), array());

        for ($i = 0; $i < (integer) $count; $i++) {
            foreach (array_keys($current) as $key) {
                $file[$i][$key] = $current[$key][$i];
            }

            $error = $file[$i]['error'];
            $original = $file[$i]['name'];
            $size = $file[$i]['size'];
            $tmp = $file[$i]['tmp_name'];
            $type = $file[$i]['type'];

            $items[$i] = new UploadedFile($tmp, $size, $error, $original, $type);
        }

        return $items;
    }

    /**
     * Parses the $_FILES into multiple \UploadedFileInterface instances.
     *
     * @param  array $uploaded
     * @param  array $files
     * @return \Zapheus\Http\Message\UploadedFileInterface[]
     */
    protected function files(array $uploaded, $files = array())
    {
        foreach ((array) $uploaded as $name => $file) {
            $array = $this->arrayify($file);

            $files[$name] = array();

            isset($file[0]) || $file = $this->convert($file, $array);

            $files[$name] = $file;
        }

        return $files;
    }

    /**
     * Generates a \Zapheus\Http\Message\UriInterface if it does not exists.
     *
     * @param  array                                   $server
     * @param  \Zapheus\Http\Message\UriInterface|null $uri
     * @return \Zapheus\Http\Message\UriInterface
     */
    protected function uri(array $server, $uri = null)
    {
        $secure = isset($server['HTTPS']) ? $server['HTTPS'] : 'off';

        $http = $secure === 'off' ? 'http' : 'https';

        $url = $http . '://' . $server['SERVER_NAME'];

        $url .= $server['SERVER_PORT'] . $server['REQUEST_URI'];

        return $uri === null ? new Uri($url) : $uri;
    }
}
