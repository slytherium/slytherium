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

/**
 * Request
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Request extends Message implements RequestInterface
{
    /**
     * @var string
     */
    protected $target = '/';

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var \Zapheus\Http\Message\UriInterface
     */
    protected $uri;

    /**
     * Initializes the request instance.
     *
     * @param string                                     $method
     * @param string                                     $target
     * @param \Zapheus\Http\Message\UriInterface|null    $uri
     * @param \Zapheus\Http\Message\StreamInterface|null $body
     * @param array                                      $headers
     * @param string                                     $version
     */
    public function __construct($method = 'GET', $target = '/', UriInterface $uri = null, StreamInterface $body = null, array $headers = array(), $version = '1.1')
    {
        parent::__construct($body, $headers, $version);

        $this->method = $method;

        $this->target = $target;

        $this->uri = $uri === null ? new Uri : $uri;
    }

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Retrieves the message's request target.
     *
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->target;
    }

    /**
     * Retrieves the URI instance.
     *
     * @return \Zapheus\Http\Message\UriInterface
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Return an instance with the provided HTTP method.
     *
     * @param  string $method
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withMethod($method)
    {
        $new = clone $this;

        $new->method = $method;

        return $new;
    }

    /**
     * Return an instance with the specific request-target.
     *
     * @param  mixed $target
     * @return static
     */
    public function withRequestTarget($target)
    {
        $new = clone $this;

        $new->target = $target;

        return $new;
    }

    /**
     * Returns an instance with the provided URI.
     *
     * @param  \Zapheus\Http\Message\UriInterface $uri
     * @param  boolean                               $preserve
     * @return static
     */
    public function withUri(UriInterface $uri, $preserve = false)
    {
        $new = clone $this;

        $new->uri = $uri;

        if (! $preserve && $host = $uri->getHost()) {
            $port = $host . ':' . $uri->getPort();

            $host = $uri->getPort() ? $port : $host;

            $new->headers['Host'] = array($host);
        }

        return $new;
    }
}
