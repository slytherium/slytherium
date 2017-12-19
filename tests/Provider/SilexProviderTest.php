<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Fixture\Providers\SilexExtendedServiceProvider;
use Slytherium\Fixture\Providers\SilexSimpleServiceProvider;
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

        $config->set('silex.simple.paths', array());

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
        $simple = new SilexProvider(new SilexSimpleServiceProvider);

        $extended = new SilexProvider(new SilexExtendedServiceProvider);

        $container = $simple->register($this->container);

        $container = $extended->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $result = $container->get('extended');

        $this->assertInstanceOf($expected, $result);
    }
}
