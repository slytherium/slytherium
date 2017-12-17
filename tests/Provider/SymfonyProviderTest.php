<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
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

        $this->bundle('FrameworkBundle');

        $this->bundle('TwigBundle');

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

        foreach ((array) $this->providers as $provider) {
            $container = $provider->register($container);
        }

        $container = $this->framework->register($container);

        $expected = 'Twig_Environment';

        $result = $container->get('twig');

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Adds a new bundle to the list of providers.
     *
     * @param  string $name
     * @return void
     */
    protected function bundle($name)
    {
        $class = 'Symfony\\Bundle\\' . $name . '\\' . $name;

        $message = $name . ' is not installed.';

        class_exists($class) || $this->markTestSkipped($message);

        $this->providers[] = new SymfonyProvider(new $class);
    }
}
