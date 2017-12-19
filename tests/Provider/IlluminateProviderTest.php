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
    const SIMPLE_PROVIDER = 'Slytherium\Fixture\Providers\IlluminateSimpleServiceProvider';

    const EXTENDED_PROVIDER = 'Slytherium\Fixture\Providers\IlluminateExtendedServiceProvider';

    /**
     * @var \Slytherium\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Slytherium\Provider\FrameworkProvider
     */
    protected $framework;

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
        $this->container = new Container;

        $class = 'Slytherium\Provider\ConfigurationInterface';

        $config = new Configuration;

        $this->container->set($class, $config);

        $this->framework = new FrameworkProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $simple = new IlluminateProvider(self::SIMPLE_PROVIDER);

        $extended = new IlluminateProvider(self::EXTENDED_PROVIDER);

        $container = $simple->register($this->container);

        $container = $extended->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $result = $container->get('extended');

        $this->assertInstanceOf($expected, $result);
    }
}
