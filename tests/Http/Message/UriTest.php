<?php

namespace Zapheus\Http\Message;

/**
 * URI Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\UriInterface
     */
    protected $uri;

    /**
     * Sets up the URI instance.
     *
     * @return void
     */
    public function setUp()
    {
        $url = 'https://me@rougin.github.io:400/about';

        $this->uri = new Uri($url);
    }

    /**
     * Tests UriInterface::__toString.
     *
     * @return void
     */
    public function testToStringMagicMethod()
    {
        $expected = 'https://me@rougin.github.io:400/about';

        $this->assertEquals($expected, (string) $this->uri);
    }

    /**
     * Tests UriInterface::authority.
     *
     * @return void
     */
    public function testAuthorityMethod()
    {
        $expected = 'me@rougin.github.io:400';

        $result = $this->uri->authority();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::fragment.
     *
     * @return void
     */
    public function testFragmentMethod()
    {
        $expected = 'test';

        $uri = $this->uri->with('fragment', $expected);

        $result = $uri->fragment();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::host.
     *
     * @return void
     */
    public function testHostMethod()
    {
        $expected = 'google.com';

        $uri = $this->uri->with('host', $expected);

        $result = $uri->host();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::path.
     *
     * @return void
     */
    public function testPathMethod()
    {
        $expected = '/test';

        $uri = $this->uri->with('path', $expected);

        $result = $uri->path();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::port.
     *
     * @return void
     */
    public function testPortMethod()
    {
        $expected = 500;

        $uri = $this->uri->with('port', $expected);

        $result = $uri->port();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::query.
     *
     * @return void
     */
    public function testQueryMethod()
    {
        $expected = 'type=user';

        $uri = $this->uri->with('query', $expected);

        $result = $uri->query();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::scheme.
     *
     * @return void
     */
    public function testSchemeMethod()
    {
        $expected = 'http';

        $uri = $this->uri->with('scheme', $expected);

        $result = $uri->scheme();

        $this->assertEquals('http', $result);
    }

    /**
     * Tests UriInterface::user.
     *
     * @return void
     */
    public function testUserMethod()
    {
        $expected = 'username:password';

        $uri = $this->uri->with('user', $expected);

        $result = $uri->user();

        $this->assertEquals($expected, $result);
    }
}
