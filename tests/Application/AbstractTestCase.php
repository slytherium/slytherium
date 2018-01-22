<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Container\Container;
use Zapheus\Container\ReflectionContainer;
use Zapheus\Http\Message\Request;

/**
 * Abstract Test Case
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Application\ApplicationInterface
     */
    protected $app;

    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/';

        $_SERVER['SERVER_NAME'] = 'rougin.github.io';

        $_SERVER['SERVER_PORT'] = 8000;
    }

    /**
     * Returns an application instance.
     *
     * @return \Zapheus\Application
     */
    protected function application()
    {
        $container = new Container(new ReflectionContainer);

        return new Application($container);
    }

    /**
     * Creates a dummy request instance.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Application\ApplicationInterface
     */
    protected function request($method, $uri)
    {
        $interface = 'Zapheus\Http\Message\RequestInterface';

        $_SERVER['REQUEST_METHOD'] = $method;

        $_SERVER['REQUEST_URI'] = $uri;

        $_SERVER['SERVER_NAME'] = 'rougin.github.io';

        $_SERVER['SERVER_PORT'] = 8000;

        $request = new Request($_SERVER);

        $this->app->set($interface, $request);

        return $this->app;
    }
}
