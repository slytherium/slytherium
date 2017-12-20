<?php

namespace Slytherium\Provider;

use Rougin\Slytherin\Template\RendererIntegration;
use Slytherium\Container\Container;

/**
 * Slytherin Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinProviderTest extends \PHPUnit_Framework_TestCase
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
        list($config, $container) = array(new Configuration, new Container);

        $config->set('app.views', __DIR__ . '/../Fixture/Views');

        $container->set('Slytherium\Provider\ConfigurationInterface', $config);

        $this->provider = new SlytherinProvider(new RendererIntegration);

        $this->framework = new FrameworkProvider;

        $this->container = $container;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $class = 'Rougin\Slytherin\Container\Container';

        $container = $this->provider->register($this->container);

        $container = $this->framework->register($container);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $expected = 'Hello world';

        $result = $container->get($renderer)->render('HelloWorld');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests BridgeContainer::has from ProviderInterface::register.
     *
     * @return void
     */
    public function testHasMethodOfSlytherinContainerFromRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $container = $this->framework->register($container);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $this->assertTrue($container->has($renderer));
    }
}
