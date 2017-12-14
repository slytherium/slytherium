<?php

namespace Slytherium\Application;

use Slytherium\Fixture\Http\Controllers\SimpleController;
use Slytherium\Fixture\Http\Middlewares\RouterMiddleware;
use Slytherium\Routing\Dispatcher;
use Slytherium\Routing\Route;
use Slytherium\Routing\Router;

/**
 * Middleware Application Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MiddlewareApplicationTest extends TestCase
{
    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->application = new MiddlewareApplication;

        $handler = get_class(new SimpleController) . '@greet';

        $router = new Router(array(new Route('GET', '/hi', $handler)));

        $middleware = new RouterMiddleware(new Dispatcher($router));

        $this->application->pipe($middleware);
    }

    /**
     * Tests AbstractApplication::run.
     *
     * @return void
     */
    public function testRunMethod()
    {
        $app = $this->request('GET', '/hi');

        $expected = 'Hello, world';

        $result = (string) $app->run();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests an unknown method.
     *
     * @return void
     */
    public function testUnknownMethod()
    {
        $this->setExpectedException('BadMethodCallException');

        $this->application->test();
    }
}
