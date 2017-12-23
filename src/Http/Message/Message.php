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
 * Message
 *
 * @package Zapheus
 * @author  Kévin Dunglas <dunglas@gmail.com>
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Message implements MessageInterface
{
    /**
     * @var \Zapheus\Http\Message\StreamInterface
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * @var string
     */
    protected $version = '1.1';

    /**
     * Initializes the message instance.
     *
     * @param \Zapheus\Http\Message\StreamInterface|null $body
     * @param array                                      $headers
     * @param string                                     $version
     */
    public function __construct(StreamInterface $body = null, array $headers = array(), $version = '1.1')
    {
        $default = new Stream(fopen('php://temp', 'r+'));

        $this->body = $body === null ? $default : $body;

        $this->headers = $headers;

        $this->version = $version;
    }

    /**
     * Returns the body of the message.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * @param  string $name
     * @return string[]
     */
    public function getHeader($name)
    {
        return $this->hasHeader($name) ? $this->headers[$name] : array();
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * @param  string $name
     * @return string
     */
    public function getHeaderLine($name)
    {
        return $this->hasHeader($name) ? implode(',', $this->headers[$name]) : '';
    }

    /**
     * Retrieves all message header values.
     *
     * @return string[][]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * @param  string $name
     * @return string[]
     */
    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    /**
     * Returns an instance with the specified header appended with the given value.
     *
     * @throws \InvalidArgumentException
     *
     * @param  string          $name
     * @param  string|string[] $value
     * @return static
     */
    public function withAddedHeader($name, $value)
    {
        $new = clone $this;

        $new->headers[$name][] = $value;

        return $new;
    }

    /**
     * Returns an instance with the specified message body.
     *
     * @throws \InvalidArgumentException
     *
     * @param  \Zapheus\Http\Message\StreamInterface $body
     * @return static
     */
    public function withBody(StreamInterface $body)
    {
        $new = clone $this;

        $new->body = $body;

        return $new;
    }

    /**
     * Returns an instance with the provided value replacing the specified header.
     *
     * @throws \InvalidArgumentException
     *
     * @param  string          $name
     * @param  string|string[] $value
     * @return static
     */
    public function withHeader($name, $value)
    {
        $new = clone $this;

        $new->headers[$name] = is_array($value) ? $value : array($value);

        return $new;
    }

    /**
     * Returns an instance with the specified HTTP protocol version.
     *
     * @param  string $version
     * @return static
     */
    public function withProtocolVersion($version)
    {
        $new = clone $this;

        $new->version = $version;

        return $new;
    }

    /**
     * Returns an instance without the specified header.
     *
     * @param  string $name
     * @return static
     */
    public function withoutHeader($name)
    {
        $instance = clone $this;

        if ($this->hasHeader($name)) {
            $new = clone $this;

            unset($new->headers[$name]);

            $instance = $new;
        }

        return $instance;
    }
}
