<?php

namespace Slytherium\Application;

use Slytherium\Container\ReflectionContainer;
use Slytherium\Http\Message\ServerRequest;

/**
 * Application Test Case
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Application\ApplicationInterface
     */
    protected $application;

    /**
     * Creates a dummy server request instance.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Slytherium\Application\ApplicationInterface
     */
    protected function request($method, $uri)
    {
        $interface = 'Slytherium\Http\Message\ServerRequestInterface';

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
