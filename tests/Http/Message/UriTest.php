<?php

namespace Slytherium\Http\Message;

/**
 * Uri Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Http\Message\UriInterface
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
     * Tests UriInterface::getAuthority.
     *
     * @return void
     */
    public function testGetAuthorityMethod()
    {
        $expected = 'me@rougin.github.io:400';

        $result = $this->uri->getAuthority();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getFragment.
     *
     * @return void
     */
    public function testGetFragmentMethod()
    {
        $expected = 'test';

        $uri = $this->uri->withFragment($expected);

        $result = $uri->getFragment();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getHost.
     *
     * @return void
     */
    public function testGetHostMethod()
    {
        $expected = 'google.com';

        $uri = $this->uri->withHost($expected);

        $result = $uri->getHost();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getPath.
     *
     * @return void
     */
    public function testGetPathMethod()
    {
        $expected = '/test';

        $uri = $this->uri->withPath($expected);

        $result = $uri->getPath();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getPort.
     *
     * @return void
     */
    public function testGetPortMethod()
    {
        $expected = 500;

        $uri = $this->uri->withPort($expected);

        $result = $uri->getPort();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getQuery.
     *
     * @return void
     */
    public function testGetQueryMethod()
    {
        $expected = 'type=user';

        $uri = $this->uri->withQuery($expected);

        $result = $uri->getQuery();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UriInterface::getScheme.
     *
     * @return void
     */
    public function testGetSchemeMethod()
    {
        $expected = 'http';

        $uri = $this->uri->withScheme($expected);

        $result = $uri->getScheme();

        $this->assertEquals('http', $result);
    }

    /**
     * Tests UriInterface::getUserInfo.
     *
     * @return void
     */
    public function testGetUserInfoMethod()
    {
        $expected = 'username:password';

        $uri = $this->uri->withUserInfo('username', 'password');

        $result = $uri->getUserInfo();

        $this->assertEquals($expected, $result);
    }
}