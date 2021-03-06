<?php

namespace Zapheus\Application;

use Zapheus\Middlelayer;
use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Http\Middlewares\RouterMiddleware;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Route;
use Zapheus\Routing\Router;

/**
 * Middlelayer Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class MiddlelayerTest extends AbstractTestCase
{
    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = new Middlelayer($this->application());

        $controller = $this->define(new HailController);

        $handler = (string) $controller . '@greet';

        $router = new Router(array(new Route('GET', '/hi', $handler)));

        $middleware = new RouterMiddleware(new Dispatcher($router));

        $this->app->pipe($middleware);
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

        $this->app->test();
    }
}
