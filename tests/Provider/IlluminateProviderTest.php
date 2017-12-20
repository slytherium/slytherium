<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;

/**
 * Illuminate Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateProviderTest extends \PHPUnit_Framework_TestCase
{
    const FOOD_PROVIDER = 'Slytherium\Fixture\Providers\FoodServiceProvider';

    const TEST_PROVIDER = 'Slytherium\Fixture\Providers\TestServiceProvider';

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
        $fooo = new IlluminateProvider(self::FOOD_PROVIDER);

        $test = new IlluminateProvider(self::TEST_PROVIDER);

        $container = $fooo->register($this->container);

        $container = $test->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\TestController';

        $result = $container->get('test');

        $this->assertInstanceOf($expected, $result);
    }
}
