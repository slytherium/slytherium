<?php

namespace Zapheus\Routing;

use Zapheus\Container\Container;
use Zapheus\Http\Server\RoutingHandler;
use Zapheus\Provider\Configuration;

/**
 * Routing Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * @var \Zapheus\Routing\RouterInterface
     */
    protected $router;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        list($config, $container) = array(new Configuration, new Container);

        $route = new Route('GET', '/', 'HailController@index');

        $config->set('app.router', $this->router = new Router(array($route)));

        $this->container = $container->set(RoutingProvider::CONFIG, $config);

        $this->provider = new RoutingProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $expected = new Route('GET', '/', 'HailController@index');

        $dispatcher = RoutingHandler::DISPATCHER;

        $container = $this->provider->register($this->container);

        $dispatcher = $container->get($dispatcher);

        $result = $dispatcher->dispatch('GET', '/');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ProviderInterface::register with a router from container.
     *
     * @return void
     */
    public function testRegisterMethodWithRouterFromContainer()
    {
        $provider = new RoutingProvider;

        $this->container->set(RoutingProvider::ROUTER, $this->router);

        $expected = new Route('GET', '/', 'HailController@index');

        $dispatcher = RoutingHandler::DISPATCHER;

        $container = $provider->register($this->container);

        $dispatcher = $container->get($dispatcher);

        $result = $dispatcher->dispatch('GET', '/');

        $this->assertEquals($expected, $result);
    }
}
