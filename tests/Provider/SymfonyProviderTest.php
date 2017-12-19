<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Fixture\Providers\SymfonyExtendedBundle;
use Slytherium\Fixture\Providers\SymfonySimpleBundle;
use Slytherium\Provider\Configuration;
use Slytherium\Provider\SymfonyProvider;

/**
 * Symfony Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyProviderTest extends \PHPUnit_Framework_TestCase
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
     * @var \Slytherium\Provider\ProviderInterface[]
     */
    protected $providers;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $class = 'Slytherium\Provider\ConfigurationInterface';

        $config = new Configuration;

        $root = __DIR__ . '/../Fixture';

        $config->set('symfony.kernel.debug', true);
        $config->set('symfony.kernel.environment', 'dev');
        $config->set('symfony.kernel.project_dir', $root);
        $config->set('symfony.kernel.root_dir', $root . '/symfony');
        $config->set('symfony.kernel.secret', 'secret');

        $this->container = new Container;

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
        $container = $this->container;

        $simple = new SymfonyProvider(new SymfonySimpleBundle);

        $extended = new SymfonyProvider(new SymfonyExtendedBundle);

        $container = $simple->register($container);

        $container = $extended->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $result = $container->get('extended');

        $this->assertInstanceOf($expected, $result);
    }
}
