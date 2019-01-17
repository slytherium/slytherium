<?php

namespace Zapheus\Http\Message;

class UriFactory
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
     * @var string|null
     */
    protected $pass = null;

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

    public function __construct(UriInterface $uri = null)
    {
        if ($uri === null)
        {
            return;
        }

        $this->fragment = $uri->fragment();

        $this->host = $uri->host();

        $this->path = $uri->path();

        $this->port = $uri->port();

        $this->query = $uri->query();

        $this->scheme = $uri->scheme();

        $this->user = $uri->user();
    }

    public function fragment($fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }

    public function host($host)
    {
        $this->host = $host;

        return $this;
    }

    public function make()
    {
        $authority = $this->host;

        $fragment = $this->fragment;

        $query = $this->query;

        if ($this->host !== '' && $this->user !== null)
        {
            $user = $this->user;

            if ($this->pass)
            {
                $user = $this->user . ':' . $this->pass;
            }

            $authority = $user . '@' . $authority;

            $authority = $authority . ':' . $this->port;
        }

        if ($query)
        {
            $query = '?' . $query;
        }

        if ($fragment)
        {
            $fragment = '#' . $fragment;
        }

        return new Uri($this->scheme . '://' . $authority . $this->path . $query . $fragment);
    }

    public function path($path)
    {
        $this->path = $path;

        return $this;
    }

    public function port($port)
    {
        $this->port = $port;

        return $this;
    }

    public function query($query)
    {
        $this->query = $query;

        return $this;
    }

    public function scheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function user($user, $pass = null)
    {
        if ($pass)
        {
            $this->pass = $pass;
        }

        $this->user = $user;

        return $this;
    }
}
