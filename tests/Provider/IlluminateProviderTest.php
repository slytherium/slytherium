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
        $events = 'Illuminate\Events\EventServiceProvider';

        $loader = 'Illuminate\Config\LoaderInterface';

        $this->container = new Container;

        // LoaderInterface only exists in Laravel v4.1.* releases.
        if (interface_exists($loader) === false) {
            $class = 'Slytherium\Provider\ConfigurationInterface';

            $config = new Configuration;

            $this->container->set($class, $config);
        }

        $this->provider = new IlluminateProvider($events);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $expected = 'Illuminate\Events\Dispatcher';

        $result = $container->get('events');

        $this->assertInstanceOf($expected, $result);
    }
}
