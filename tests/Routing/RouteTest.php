<?php

namespace Zapheus\Routing;

use Zapheus\Routing\Route;

/**
 * Route Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Routing\Route
     */
    protected $route;

    /**
     * Sets up the route instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->route = new Route('GET', '/test', 'HailController@greet');
    }

    /**
     * Tests Route::uri.
     *
     * @return void
     */
    public function testUriMethod()
    {
        $expected = (string) '/test';

        $result = $this->route->uri();

        $this->assertEquals($expected, $result);
    }
}
