<?php

namespace Zapheus\Container;

use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Http\Controllers\LaudController;

/**
 * Reflection Container Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReflectionContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Container\ContainerInterface
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
        $name = get_class(new HailController);

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
        $laud = new LaudController(new HailController);

        $name = get_class($laud);

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
        $exception = 'Zapheus\Container\NotFoundException';

        $this->setExpectedException($exception);

        $this->container->get('hail');
    }
}
