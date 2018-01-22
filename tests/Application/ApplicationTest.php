<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Providers\TestProvider;
use Zapheus\Http\Message\Response;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Router;

/**
 * Application Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApplicationTest extends AbstractTestCase
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

        $headers = array('name' => array('Zapheus'));

        $response = new Response(200, $headers);

        $this->application->set($interface, $response);
    }

    /**
     * Tests Application::has.
     *
     * @return void
     */
    public function testHasMethod()
    {
        $interface = 'Zapheus\Http\Message\ResponseInterface';

        $this->assertTrue($this->application->has($interface));
    }

    /**
     * Tests Application::providers.
     *
     * @return void
     */
    public function testProvidersMethod()
    {
        $this->application->add($test = new TestProvider);

        $expected = array(get_class($test));

        $result = $this->application->providers();

        $this->assertEquals($expected, $result);
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
