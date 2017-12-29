<?php

namespace Zapheus\Http\Message;

/**
 * URI Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface UriInterface
{
    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function __toString();

    /**
     * Retrieves the authority component of the URI.
     *
     * @return string
     */
    public function getAuthority();

    /**
     * Retrieves the fragment component of the URI.
     *
     * @return string
     */
    public function getFragment();

    /**
     * Retrieves the host component of the URI.
     *
     * @return string
     */
    public function getHost();

    /**
     * Retrieves the path component of the URI.
     *
     * @return string
     */
    public function getPath();

    /**
     * Retrieves the port component of the URI.
     *
     * @return integer|null
     */
    public function getPort();

    /**
     * Retrieves the query string of the URI.
     *
     * @return string
     */
    public function getQuery();

    /**
     * Retrieves the scheme component of the URI.
     *
     * @return string
     */
    public function getScheme();

    /**
     * Retrieves the user information component of the URI.
     *
     * @return string
     */
    public function getUserInfo();

    /**
     * Returns an instance with the specified URI fragment.
     *
     * @param  string $fragment
     * @return static
     */
    public function withFragment($fragment);

    /**
     * Returns an instance with the specified host.
     *
     * @param  string $host
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withHost($host);

    /**
     * Returns an instance with the specified path.
     *
     * @param  string $path
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withPath($path);

    /**
     * Returns an instance with the specified port.
     *
     * @param  integer|null $port
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withPort($port);

    /**
     * Returns an instance with the specified query string.
     *
     * @param  string $query
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withQuery($query);

    /**
     * Returns an instance with the specified scheme.
     *
     * @param  string $scheme
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withScheme($scheme);

    /**
     * Returns an instance with the specified user information.
     *
     * @param  string $user
     * @param  null|string $password
     * @return static
     */
    public function withUserInfo($user, $password = null);
}
