<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Container\Container;
use Zapheus\Container\ReflectionContainer;
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
class MiddlewareApplicationTest extends AbstractTestCase
{
    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $reflection = new ReflectionContainer;

        $application = new Application(new Container($reflection));

        $this->application = new MiddlewareApplication($application);

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
