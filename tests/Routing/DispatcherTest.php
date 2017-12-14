<?php

namespace Slytherium\Routing;

use Slytherium\Container\ReflectionContainer;
use Slytherium\Fixture\Http\Controllers\ExtendedController;
use Slytherium\Fixture\Http\Controllers\SimpleController;
use Slytherium\Routing\Dispatcher;
use Slytherium\Routing\Resolver;
use Slytherium\Routing\Router;

/**
 * Dispatcher Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Routing\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Sets up the dispatcher instance.
     *
     * @return void
     */
    public function setUp()
    {
        list($simple, $extended) = array(new SimpleController, null);

        $extended = new ExtendedController($simple);

        $router = new Router;

        $router->get('/greeeeet', get_class($simple) . '@greet');

        $router->get('/helloo/{name}', function ($name = 'Doe') {
            $message = sprintf('Hello, my name is %s', $name);

            return $message . ' and this is the Slytherin test.';
        });

        $this->dispatcher = new Dispatcher($router);
    }

    /**
     * Tests DispatcherInterface::dispatch.
     *
     * @return void
     */
    public function testDispatchMethod()
    {
        $simple = get_class(new SimpleController);

        $expected = array($simple . '@greet', array());

        $resolver = $this->dispatcher->dispatch('GET', '/greeeeet');

        $result = $resolver->result();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests DispatcherInterface::dispatch with closure as handler.
     *
     * @return void
     */
    public function testDispatchMethodWithClosureAsHandler()
    {
        $expected = 'Hello, my name is Royce and this is the Slytherin test.';

        $resolver = $this->dispatcher->dispatch('GET', '/helloo/Royce');

        $result = $resolver->resolve(new ReflectionContainer);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests DispatcherInterface::dispatch with \UnexpectedValueException.
     *
     * @return void
     */
    public function testDispatchMethodWithUnexpectedValueException()
    {
        $this->setExpectedException('UnexpectedValueException');

        $resolver = $this->dispatcher->dispatch('GET', '/404');
    }
}
