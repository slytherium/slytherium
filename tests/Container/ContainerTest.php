<?php

namespace Zapheus\Container;

use Zapheus\Container\ReflectionContainer;
use Zapheus\Fixture\Http\Controllers\HailController;

/**
 * Container Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
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
        $this->container = new Container;
    }

    /**
     * Tests ContainerInterface::delegate method.
     *
     * @return void
     */
    public function testDelegateMethod()
    {
        $hail = new HailController;

        $name = get_class($hail);

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
        $hail = new HailController;

        $name = get_class($hail);

        $this->container->set('hail', $hail);

        $instance = $this->container->get('hail');

        $this->assertInstanceOf($name, $instance);
    }

    /**
     * Tests ContainerInterface::get method with NotFoundException.
     *
     * @return void
     */
    public function testGetMethodWithNotFoundException()
    {
        $exception = 'Zapheus\Container\NotFoundException';

        $this->setExpectedException($exception);

        $this->container->get('hail');
    }

    /**
     * Tests ContainerInterface::set method.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $this->container->set('hail', new HailController);

        $this->assertTrue($this->container->has('hail'));
    }

    /**
     * Tests ContainerInterface::set method with ContainerException.
     *
     * @return void
     */
    public function testSetMethodWithContainerException()
    {
        $exception = 'Zapheus\Container\ContainerException';

        $this->setExpectedException($exception);

        $this->container->set('boolean', true);
    }
}
