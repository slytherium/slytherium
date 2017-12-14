<?php

namespace Slytherium\Container;

use Slytherium\Container\ReflectionContainer;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Container Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Container\ContainerInterface
     */
    protected $container;

    /**
     * Sets up the container instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new Container;
    }

    /**
     * Tests ContainerInterface::delegate method.
     *
     * @return void
     */
    public function testDelegateMethod()
    {
        $simple = new SimpleController;

        $name = get_class($simple);

        $this->container->delegate(new ReflectionContainer);

        $instance = $this->container->get($name);

        $this->assertInstanceOf($name, $instance);
    }

    /**
     * Tests ContainerInterface::get method.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $simple = new SimpleController;

        $name = get_class($simple);

        $this->container->set('simple', $simple);

        $instance = $this->container->get('simple');

        $this->assertInstanceOf($name, $instance);
    }

    /**
     * Tests ContainerInterface::get method with NotFoundException.
     *
     * @return void
     */
    public function testGetMethodWithNotFoundException()
    {
        $exception = 'Slytherium\Container\NotFoundException';

        $this->setExpectedException($exception);

        $this->container->get('simple');
    }

    /**
     * Tests ContainerInterface::set method.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $this->container->set('simple', new SimpleController);

        $this->assertTrue($this->container->has('simple'));
    }

    /**
     * Tests ContainerInterface::set method with ContainerException.
     *
     * @return void
     */
    public function testSetMethodWithContainerException()
    {
        $exception = 'Slytherium\Container\ContainerException';

        $this->setExpectedException($exception);

        $this->container->set('boolean', true);
    }
}
