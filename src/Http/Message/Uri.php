<?php

namespace Zapheus\Http\Message;

/**
 * URI
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Uri extends Mutator implements UriInterface
{
    /**
     * @var string
     */
    protected $fragment = '';

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var integer|null
     */
    protected $port = null;

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var string
     */
    protected $scheme = '';

    /**
     * @var string
     */
    protected $uri = '';

    /**
     * @var string
     */
    protected $user = '';

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
     * Returns the string representation as a URI reference.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->uri;
    }

    /**
     * Returns the authority component of the URI.
     *
     * @return string
     */
    public function authority()
    {
        $authority = $this->host;

        if ($this->host !== '' && $this->user !== null) {
            $authority = $this->user . '@' . $authority;

            $authority = $authority . ':' . $this->port;
        }

        return $authority;

        // getAuthority
    }

    /**
     * Returns the fragment component of the URI.
     *
     * @return string
     */
    public function fragment()
    {
        return $this->fragment;

        // getFragment
        // withFragment
    }

    /**
     * Returns the host component of the URI.
     *
     * @return string
     */
    public function host()
    {
        return $this->host;

        // getHost
        // withHost
    }

    /**
     * Returns the path component of the URI.
     *
     * @return string
     */
    public function path()
    {
        return $this->path;

        // getPath
        // withPath
    }

    /**
     * Returns the port component of the URI.
     *
     * @return null|integer
     */
    public function port()
    {
        return $this->port;

        // getPort
        // withPort
    }

    /**
     * Returns the query string of the URI.
     *
     * @return string
     */
    public function query()
    {
        return $this->query;

        // getQuery
        // withQuery
    }

    /**
     * Returns the scheme component of the URI.
     *
     * @return string
     */
    public function scheme()
    {
        return $this->scheme;

        // getScheme
        // withScheme
    }

    /**
     * Returns the user information component of the URI.
     *
     * @return string
     */
    public function user()
    {
        return $this->user;

        // getUserInfo
        // withUserInfo
    }

    /**
     * Returns an URI instance based from the server parameters.
     *
     * @param  array $server
     * @return self
     */
    public static function instance(array $server)
    {
        isset($server['HTTPS']) || $server['HTTPS'] = 'off';

        $http = ($server['HTTPS'] === 'off' ? 'http' : 'https') . '://';

        $port = $server['SERVER_PORT'] . $server['REQUEST_URI'];

        return new Uri($http . $server['SERVER_NAME'] . $port);
    }
}
