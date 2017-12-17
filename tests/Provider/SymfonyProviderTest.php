<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Provider\Configuration;
use Slytherium\Provider\SymfonyProvider;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

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

        $this->providers[] = new SymfonyProvider(new FrameworkBundle);
        $this->providers[] = new SymfonyProvider(new TwigBundle);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->container;

        foreach ($this->providers as $provider) {
            $result = $provider->register($container);

            $container = $result;
        }

        $kernel = $container->get('Slytherium\Provider\Symfony\Kernel');

        $kernel->boot();

        $expected = 'Twig_Environment';

        $result = $kernel->getContainer()->get('twig');

        $this->assertInstanceOf($expected, $result);
    }
}
