<?php

namespace Zapheus\Application;

use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Http\Middlewares\RouterMiddleware;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Route;
use Zapheus\Routing\Router;

/**
 * Middleware Application Test
 *
 * @package Zapheus
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
        parent::setUp();

        $this->application = new MiddlewareApplication;

        $handler = get_class(new HailController) . '@greet';

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
