<?php

namespace Slytherium\Container;

use Slytherium\Container\ReflectionContainer;
use Slytherium\Fixture\Http\Controllers\ExtendedController;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Reflection Container Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ReflectionContainerTest extends \PHPUnit_Framework_TestCase
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
        $this->container = new ReflectionContainer;
    }

    /**
     * Tests ContainerInterface::get.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $simple = new SimpleController;

        $name = get_class($simple);

        $instance = $this->container->get($name);

        $this->assertInstanceOf($name, $instance);
    }

    /**
     * Tests ContainerInterface::get with constructor classes.
     *
     * @return void
     */
    public function testGetMethodWithConstructorClasses()
    {
        $extended = new ExtendedController(new SimpleController);

        $name = get_class($extended);

        $instance = $this->container->get($name);

        $this->assertInstanceOf($name, $instance);
    }

    /**
     * Tests ContainerInterface::get methodh NotFoundException.
     *
     * @return void
     */
    public function testGetMethodWithNotFoundException()
    {
        $exception = 'Slytherium\Container\NotFoundException';

        $this->setExpectedException($exception);

        $this->container->get('simple');
    }
}
