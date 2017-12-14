<?php

namespace Slytherium\Routing;

use Slytherium\Routing\Router;

/**
 * Router Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Routing\RouterInterface
     */
    protected $router;

    /**
     * Sets up the router instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->router = new Router;
    }

    /**
     * Tests RouterInterface::add.
     *
     * @return void
     */
    public function testAddMethod()
    {
        $this->router->get('/greet/:id', 'SimpleController@greet');

        $this->assertTrue($this->router->has('GET', '/greet/rrg'));
    }

    /**
     * Tests RouterInterface::routes.
     *
     * @return void
     */
    public function testRoutesMethod()
    {
        $expected = 10;

        $this->router->connect('/', 'SimpleController@greet');
        $this->router->delete('/', 'SimpleController@greet');
        $this->router->get('/', 'SimpleController@greet');
        $this->router->head('/', 'SimpleController@greet');
        $this->router->options('/', 'SimpleController@greet');
        $this->router->patch('/', 'SimpleController@greet');
        $this->router->post('/', 'SimpleController@greet');
        $this->router->purge('/', 'SimpleController@greet');
        $this->router->put('/', 'SimpleController@greet');
        $this->router->trace('/', 'SimpleController@greet');

        $result = $this->router->routes();

        $this->assertCount($expected, $result);
    }
}
