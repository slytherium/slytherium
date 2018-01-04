<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Http\Message\Response;
use Zapheus\Http\Message\ServerRequest;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Router;

/**
 * Application Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApplicationTest extends TestCase
{
    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->application = new Application;

        $dispatcher = 'Zapheus\Routing\DispatcherInterface';

        $router = new Router;

        $router->get('/', get_class(new HailController) . '@greet');

        $this->application->set($dispatcher, new Dispatcher($router));

        $interface = 'Zapheus\Http\Message\ResponseInterface';

        $response = new Response;

        $response = $response->withHeader('name', 'Zapheus');

        $this->application->set($interface, $response);
    }

    /**
     * Tests AbstractApplication::run.
     *
     * @return void
     */
    public function testRunMethod()
    {
        $app = $this->request('GET', '/');

        $expected = 'Hello, world';

        $result = (string) $app->run();

        $this->assertEquals($expected, $result);
    }
}
