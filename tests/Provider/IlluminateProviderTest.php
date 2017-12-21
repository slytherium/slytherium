<?php

namespace Zapheus\Provider;

use Zapheus\Container\Container;

/**
 * Illuminate Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateProviderTest extends \PHPUnit_Framework_TestCase
{
    const FOOD_PROVIDER = 'Zapheus\Fixture\Providers\FoodServiceProvider';

    const TEST_PROVIDER = 'Zapheus\Fixture\Providers\TestServiceProvider';

    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\FrameworkProvider
     */
    protected $framework;

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
        $message = 'Illuminate Container is not yet installed.';

        $container = 'Illuminate\Container\Container';

        class_exists($container) || $this->markTestSkipped($message);

        $this->container = new Container;

        $class = 'Zapheus\Provider\ConfigurationInterface';

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

        $expected = 'Zapheus\Fixture\Http\Controllers\TestController';

        $result = $container->get('test');

        $this->assertInstanceOf($expected, $result);
    }
}
