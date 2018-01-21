<?php

namespace Zapheus\Http\Message;

/**
 * Message
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Message extends Mutator implements MessageInterface
{
    /**
     * @var \Zapheus\Http\Message\Collection
     */
    protected $headers;

    /**
     * @var \Zapheus\Http\Message\Stream
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
        $this->headers = new Collection($headers);

        $stream = fopen('php://temp', 'r+');

        $stream = $stream === false ? null : $stream;

        $this->stream = new Stream($stream);
    }

    /**
     * Returns all message header values.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function headers()
    {
        return $this->headers;

        // getHeaders
        // hasHeader
        // getHeader
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
}
