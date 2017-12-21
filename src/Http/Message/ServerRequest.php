<?php

namespace Zapheus\Http\Message;

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Zapheus\Utility;

/**
 * Server Request
 *
 * @package Zapheus
 * @author  Kévin Dunglas <dunglas@gmail.com>
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
        $uri = Utility::uri($server, $uri);

        parent::__construct($server['REQUEST_METHOD'], $server['REQUEST_URI'], $uri, $body, $headers, $version);

        $this->cookies = $cookies;

        $this->data = $data;

        $this->query = $query;

        $this->server = $server;

        $this->uploaded = Utility::files($uploaded);
    }

    /**
     * Retrieve a single derived request attribute.
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
     * Return an instance with the specified derived request attribute.
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
     * Return an instance with the specified cookies.
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
     * Return an instance with the specified body parameters.
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
     * Return an instance with the specified query string arguments.
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
     * Return an instance that removes the specified derived request attribute.
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
}
