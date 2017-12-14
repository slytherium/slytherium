<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Application\Router;
use Slytherium\Container\ReflectionContainer;
use Slytherium\Fixture\Http\Controllers\ExtendedController;
use Slytherium\Fixture\Http\Controllers\SimpleController;
use Slytherium\Http\Message\ServerRequest;

/**
 * Router Application Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Application\ApplicationInterface
     */
    protected $application;

    /**
     * @var string
     */
    protected $interface = 'Slytherium\Http\Message\ServerRequestInterface';

    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        $server = array('SERVER_PORT' => 8000, 'REQUEST_METHOD' => 'GET');

        $server['REQUEST_URI'] = '/greet';
        $server['SERVER_NAME'] = 'rougin.github.io';

        $this->application = new Router;

        $this->application->set($this->interface, new ServerRequest($server));

        $this->application->delegate(new ReflectionContainer);

        $extended = get_class(new ExtendedController(new SimpleController));

        $this->application->get('/greet', $extended . '@greet');
    }

    /**
     * Tests ApplicationInterface::run.
     *
     * @return void
     */
    public function testRunMethod()
    {
        $expected = 'Hello, world and people';

        $result = (string) $this->application->run();

        $this->assertEquals($expected, $result);
    }
}
