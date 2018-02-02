<?php

namespace Zapheus\Provider;

use Zapheus\Container\Container;

/**
 * Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FrameworkProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new Container;

        $this->provider = new FrameworkProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $expected = 'Zapheus\Container\CompositeContainer';

        $result = $this->provider->register($this->container);

        $this->assertInstanceOf($expected, $result);
    }
}
