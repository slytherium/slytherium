<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Application\Middleware;
use Slytherium\Container\ReflectionContainer;
use Slytherium\Fixture\Http\Middlewares\RouterMiddleware;
use Slytherium\Http\Message\ServerRequest;
use Slytherium\Routing\Dispatcher;
use Slytherium\Routing\Route;
use Slytherium\Routing\Router;

/**
 * Middleware Application Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Application\ApplicationInterface
     */
    protected $application;

    /**
     * @var string
     */
    protected $interface = 'Slytherium\Http\Message\ServerRequestInterface';

    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        $server = array('SERVER_PORT' => 8000, 'REQUEST_METHOD' => 'GET');

        $server['REQUEST_URI'] = '/hi';
        $server['SERVER_NAME'] = 'rougin.github.io';

        $extended = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $router = new Router(array(new Route('GET', '/hi', $extended . '@greet')));

        $this->application = new Middleware;

        $this->application->set($this->interface, new ServerRequest($server));

        $this->application->delegate(new ReflectionContainer);

        $this->application->pipe(new RouterMiddleware(new Dispatcher($router)));
    }

    /**
     * Tests ApplicationInterface::run.
     *
     * @return void
     */
    public function testRunMethod()
    {
        $expected = 'Hello, world and people';

        $result = (string) $this->application->run();

        $this->assertEquals($expected, $result);
    }
}
