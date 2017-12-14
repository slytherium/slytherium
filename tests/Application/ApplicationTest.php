<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Fixture\Http\Controllers\SimpleController;
use Slytherium\Http\Message\Response;
use Slytherium\Http\Message\ServerRequest;
use Slytherium\Routing\Dispatcher;
use Slytherium\Routing\Router;

/**
 * Application Test
 *
 * @package Slytherium
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
        $this->application = new Application;

        $dispatcher = 'Slytherium\Routing\DispatcherInterface';

        $router = new Router;

        $router->get('/', get_class(new SimpleController) . '@greet');

        $this->application->set($dispatcher, new Dispatcher($router));

        $interface = 'Slytherium\Http\Message\ResponseInterface';

        $response = new Response;

        $response = $response->withHeader('name', 'Slytherium');

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
