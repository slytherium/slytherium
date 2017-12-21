<?php

namespace Zapheus\Application;

use Zapheus\Container\ReflectionContainer;
use Zapheus\Http\Message\ServerRequest;

/**
 * Application Test Case
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Application\ApplicationInterface
     */
    protected $application;

    /**
     * Creates a dummy server request instance.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Application\ApplicationInterface
     */
    protected function request($method, $uri)
    {
        $interface = 'Zapheus\Http\Message\ServerRequestInterface';

        $server = array();

        $server['REQUEST_METHOD'] = $method;
        $server['REQUEST_URI'] = $uri;
        $server['SERVER_NAME'] = 'rougin.github.io';
        $server['SERVER_PORT'] = 8000;

        $request = new ServerRequest($server);

        $this->application->delegate(new ReflectionContainer);

        $this->application->set($interface, $request);

        return $this->application;
    }
}
