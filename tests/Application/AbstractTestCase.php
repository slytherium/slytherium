<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Http\Message\RequestFactory;

/**
 * Abstract Test Case
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Application
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
        return new Application;
    }

    /**
     * Defines the instance to the application.
     *
     * @param  mixed $instance
     * @return string
     */
    protected function define($instance)
    {
        $class = get_class($instance);

        $this->app->set($class, $instance);

        return (string) $class;
    }

    /**
     * Creates a dummy request instance.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Application
     */
    protected function request($method, $uri)
    {
        $interface = 'Zapheus\Http\Message\RequestInterface';

        $_SERVER['REQUEST_METHOD'] = $method;

        $_SERVER['REQUEST_URI'] = $uri;

        $_SERVER['SERVER_NAME'] = 'rougin.github.io';

        $_SERVER['SERVER_PORT'] = 8000;

        $factory = new RequestFactory;

        $factory->server($_SERVER);

        $request = $factory->make();

        $this->app->set($interface, $request);

        return $this->app;
    }
}
