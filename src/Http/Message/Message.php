<?php

namespace Zapheus\Http\Message;

/**
 * Message
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Message extends Mutator implements MessageInterface
{
    /**
     * @var array
     */
    protected $headers = array();

    /**
     * @var \Zapheus\Http\Message\StreamInterface
     */
    protected $stream;

    /**
     * @var string
     */
    protected $version = '1.1';

    /**
     * Initializes the message instance.
     *
     * @param array $headers
     */
    public function __construct(array $headers = array())
    {
        $stream = fopen('php://temp', 'r+');

        $this->headers = (array) $headers;

        $stream = $stream === false ? null : $stream;

        $this->stream = new Stream($stream);
    }

    /**
     * Returns a message header value by the given case-insensitive name.
     *
     * @param  string $name
     * @return array
     */
    public function header($name)
    {
        $exists = isset($this->headers[$name]);

        return $exists ? $this->headers[$name] : array();

        // getHeader
    }

    /**
     * Returns all message header values.
     *
     * @return array
     */
    public function headers()
    {
        return $this->headers;

        // getHeaders
        // hasHeader
        // getHeaderLine
        // withHeader
        // withAddedHeader
        // withoutHeader
    }

    /**
     * Returns the stream of the message.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function stream()
    {
        return $this->stream;

        // getBody
        // withBody
    }

    /**
     * Returns the HTTP protocol version as a string.
     *
     * @return string
     */
    public function version()
    {
        return $this->version;

        // getProtocolVersion
        // withProtocolVersion
    }

    /**
     * Returns header values from $_SERVER parameters.
     *
     * @param  array $server
     * @return array
     */
    public static function request(array $server)
    {
        $headers = array();

        foreach ((array) $server as $key => $value)
        {
            $http = strpos($key, 'HTTP_') === 0;

            $string = strtolower(substr($key, 5));

            $key = str_replace('_', '-', $string);

            $http && $headers[$key] = $value;
        }

        return $headers;
    }
}
