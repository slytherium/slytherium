<?php

namespace Slytherium\Provider;

use Rougin\Slytherin\Template\RendererIntegration;
use Slytherium\Container\Container;
use Slytherium\Fixture\Http\Controllers\SimpleController;
use Slytherium\Provider\Configuration;
use Slytherium\Provider\SlytherinProvider;

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

        $this->container = $container;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $renderer = $container->get($renderer);

        $expected = 'Hello world';

        $result = $renderer->render('HelloWorld');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests BridgeContainer::has from ProviderInterface::register.
     *
     * @return void
     */
    public function testHasMethodOfBridgeContainerFromRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $this->assertTrue($container->has($renderer));
    }

    /**
     * Tests BridgeContainer::set from ProviderInterface::register.
     *
     * @return void
     */
    public function testSetMethodOfBridgeContainerFromRegisterMethod()
    {
        $expected = 'Slytherium\Fixture\Http\Controllers\SimpleController';

        $container = $this->provider->register($this->container);

        $container = $container->set($expected, new SimpleController);

        $result = $container->get($expected);

        $this->assertInstanceOf($expected, $result);
    }
}
