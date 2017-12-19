<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
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
        $message = 'Silex Providers is not installed.';

        $twig = 'Silex\Provider\TwigServiceProvider';

        class_exists($twig) || $this->markTestSkipped($message);

        $this->container = new Container;

        $class = 'Slytherium\Provider\ConfigurationInterface';

        $config = new Configuration;

        $config->set('silex.twig.path', array());

        $this->container->set($class, $config);

        $this->framework = new FrameworkProvider;

        $this->provider = new SilexProvider(new $twig);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $container = $this->framework->register($container);

        $expected = 'Twig_Environment';

        $result = $container->get('twig');

        $this->assertInstanceOf($expected, $result);
    }
}
