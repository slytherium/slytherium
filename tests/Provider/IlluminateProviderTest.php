<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Provider\Configuration;
use Slytherium\Provider\IlluminateProvider;

/**
 * Illuminate Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Slytherium\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $class = 'Slytherium\Provider\ConfigurationInterface';

        $events = 'Illuminate\Events\EventServiceProvider';

        $this->container = new Container;

        $this->container->set($class, new Configuration);

        $this->provider = new IlluminateProvider($events);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $expected = 'Illuminate\Events\Dispatcher';

        $container = $this->provider->register($this->container);

        $result = $container->get('events');

        $this->assertInstanceOf($expected, $result);
    }
}
