<?php

namespace Zapheus\Http\Message;

/**
 * Uri Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface UriInterface extends MutatorInterface
{
    /**
     * Returns the authority component of the URI.
     *
     * @return string
     */
    public function authority();

    /**
     * Returns the fragment component of the URI.
     *
     * @return string
     */
    public function fragment();

    /**
     * Returns the host component of the URI.
     *
     * @return string
     */
    public function host();

    /**
     * Returns the path component of the URI.
     *
     * @return string
     */
    public function path();

    /**
     * Returns the port component of the URI.
     *
     * @return null|integer
     */
    public function port();

    /**
     * Returns the query string of the URI.
     *
     * @return string
     */
    public function query();

    /**
     * Returns the scheme component of the URI.
     *
     * @return string
     */
    public function scheme();

    /**
     * Returns the user information component of the URI.
     *
     * @return string
     */
    public function user();
}
