<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Fixture\Providers\SilexExtendedProvider;
use Slytherium\Fixture\Providers\SilexSimpleProvider;
use Slytherium\Provider\Configuration;
use Slytherium\Provider\SilexProvider;

/**
 * Silex Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SilexProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Slytherium\Provider\FrameworkProvider
     */
    protected $framework;

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
        $simple = new SilexProvider(new SilexSimpleProvider);

        $extended = new SilexProvider(new SilexExtendedProvider);

        $container = $simple->register($this->container);

        $container = $extended->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $result = $container->get('extended');

        $this->assertInstanceOf($expected, $result);
    }
}
