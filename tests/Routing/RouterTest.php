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
        $this->router->get('/greet/:id', 'HailController@greet');

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

        $this->router->connect('/', 'HailController@greet');
        $this->router->delete('/', 'HailController@greet');
        $this->router->get('/', 'HailController@greet');
        $this->router->head('/', 'HailController@greet');
        $this->router->options('/', 'HailController@greet');
        $this->router->patch('/', 'HailController@greet');
        $this->router->post('/', 'HailController@greet');
        $this->router->purge('/', 'HailController@greet');
        $this->router->put('/', 'HailController@greet');
        $this->router->trace('/', 'HailController@greet');

        $result = $this->router->routes();

        $this->assertCount($expected, $result);
    }
}
