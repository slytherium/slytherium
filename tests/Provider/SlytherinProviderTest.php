<?php

namespace Zapheus\Provider;

use Rougin\Slytherin\Template\RendererIntegration;
use Zapheus\Container\Container;

/**
 * Slytherin Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinProviderTest extends \PHPUnit_Framework_TestCase
{
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
        $message = 'Slytherin Renderer is not yet installed.';

        $renderer = 'Rougin\Slytherin\Template\Renderer';

        class_exists($renderer) || $this->markTestSkipped($message);

        list($config, $container) = array(new Configuration, new Container);

        $config->set('app.views', __DIR__ . '/../Fixture/Views');

        $container->set('Zapheus\Provider\ConfigurationInterface', $config);

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
