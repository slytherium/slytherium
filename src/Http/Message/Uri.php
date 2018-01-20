<?php

namespace Zapheus\Http\Message;

/**
 * URI
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Uri implements UriInterface
{
    /**
     * @var string
     */
    protected $scheme = '';

    /**
     * @var string
     */
    protected $user = '';

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var integer|null
     */
    protected $port = null;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var string
     */
    protected $fragment = '';

    /**
     * @var string
     */
    protected $uri = '';

    /**
     * Initializes the URI instance.
     *
     * @param string $uri
     */
    public function __construct($uri = '')
    {
        $parts = parse_url($uri) ?: array();

        foreach ($parts as $key => $value) {
            $key === 'user' && $this->user = $value;

            $this->$key = $value;
        }

        $this->uri = $uri;
    }

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->uri;
    }

    /**
     * Retrieves the authority component of the URI.
     *
     * @return string
     */
    public function getAuthority()
    {
        $authority = $this->host;

        if (! empty($this->host) && ! empty($this->user)) {
            $authority = $this->user . '@' . $authority;

            $authority .= ':'. $this->port;
        }

        return $authority;
    }

    /**
     * Retrieves the fragment component of the URI.
     *
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Retrieves the host component of the URI.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Retrieves the path component of the URI.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Retrieves the port component of the URI.
     *
     * @return null|integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Retrieves the query string of the URI.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Retrieves the scheme component of the URI.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Retrieves the user information component of the URI.
     *
     * @return string
     */
    public function getUserInfo()
    {
        return $this->user;
    }

    /**
     * Returns an instance with the specified URI fragment.
     *
     * @param  string $fragment
     * @return static
     */
    public function withFragment($fragment)
    {
        $new = clone $this;

        $new->fragment = $fragment;

        return $new;
    }

    /**
     * Returns an instance with the specified host.
     *
     * @param  string $host
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withHost($host)
    {
        // TODO: Add \InvalidArgumentException

        $new = clone $this;

        $new->host = $host;

        return $new;
    }

    /**
     * Returns an instance with the specified path.
     *
     * @param  string $path
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withPath($path)
    {
        // TODO: Add \InvalidArgumentException

        $new = clone $this;

        $new->path = $path;

        return $new;
    }

    /**
     * Returns an instance with the specified port.
     *
     * @param  null|integer $port
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withPort($port)
    {
        // TODO: Add \InvalidArgumentException

        $new = clone $this;

        $new->port = $port;

        return $new;
    }

    /**
     * Returns an instance with the specified query string.
     *
     * @param  string $query
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withQuery($query)
    {
        // TODO: Add \InvalidArgumentException

        $new = clone $this;

        $new->query = $query;

        return $new;
    }

    /**
     * Returns an instance with the specified scheme.
     *
     * @param  string $scheme
     * @return static
     *
     * @throws \InvalidArgumentException
     */
    public function withScheme($scheme)
    {
        // TODO: Add \InvalidArgumentException

        $new = clone $this;

        $new->scheme = $scheme;

        return $new;
    }

    /**
     * Returns an instance with the specified user information.
     *
     * @param  string      $user
     * @param  null|string $password
     * @return static
     */
    public function withUserInfo($user, $password = null)
    {
        $new = clone $this;

        $new->user = $user . ':' . $password;

        return $new;
    }
}
