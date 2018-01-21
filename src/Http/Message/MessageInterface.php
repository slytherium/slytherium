<?php

namespace Zapheus\Http\Message;

/**
 * Message Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface MessageInterface extends MutatorInterface
{
    /**
     * Returns all message header values.
     *
     * @return \Zapheus\Http\Message\Collection
     */
    public function headers();

    /**
     * Returns the stream of the message.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function stream();

    /**
     * Returns the HTTP protocol version as a string.
     *
     * @return string
     */
    public function version();
}
