<?php

namespace Zapheus\Container;

use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Http\Controllers\LaudController;

/**
 * Composite Container Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CompositeContainerTest extends \PHPUnit_Framework_TestCase
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
        list($first, $second) = array(new Container, new Container);

        $container = new CompositeContainer;

        $first->set('hail', $hail = new HailController);

        $second->set('laud', new LaudController($hail));

        $this->container = $container->add($first)->add($second);
    }

    /**
     * Tests ContainerInterface::get.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $name = get_class(new HailController);

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

        $this->container->get('test');
    }

    /**
     * Tests ContainerInterface::has.
     *
     * @return void
     */
    public function testHasMethod()
    {
        $this->assertTrue($this->container->has('hail'));
    }
}
