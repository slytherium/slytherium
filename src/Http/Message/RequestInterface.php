<?php

namespace Slytherium\Http\Message;

/**
 * Request Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RequestInterface extends MessageInterface
{
    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string
     */
    public function getMethod();

    /**
     * Retrieves the message's request target.
     *
     * @return string
     */
    public function getRequestTarget();

    /**
     * Retrieves the URI instance.
     *
     * @return \Slytherium\Http\Message\UriInterface
     */
    public function getUri();

    /**
     * Return an instance with the provided HTTP method.
     *
     * @param  string $method
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withMethod($method);

    /**
     * Return an instance with the specific request-target.
     *
     * @param  mixed $target
     * @return static
     */
    public function withRequestTarget($target);

    /**
     * Returns an instance with the provided URI.
     *
     * @param  \Slytherium\Http\Message\UriInterface $uri
     * @param  boolean                               $preserve
     * @return static
     */
    public function withUri(UriInterface $uri, $preserve = false);
}
