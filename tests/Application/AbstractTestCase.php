<?php

namespace Zapheus\Application;

use Zapheus\Container\ReflectionContainer;
use Zapheus\Http\Message\Request;

/**
 * Abstract Test Case
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Application\ApplicationInterface
     */
    protected $application;

    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'rougin.github.io';
        $_SERVER['SERVER_PORT'] = 8000;
    }

    /**
     * Creates a dummy request instance.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Application\ApplicationInterface
     */
    protected function request($method, $uri)
    {
        $interface = 'Zapheus\Http\Message\RequestInterface';

        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;
        $_SERVER['SERVER_NAME'] = 'rougin.github.io';
        $_SERVER['SERVER_PORT'] = 8000;

        $request = new Request($_SERVER);

        $this->application->delegate(new ReflectionContainer);

        $this->application->set($interface, $request);

        return $this->application;
    }
}
