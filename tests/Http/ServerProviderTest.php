<?php

namespace Zapheus\Http;

use Zapheus\Container\Container;
use Zapheus\Container\ReflectionContainer;
use Zapheus\Provider\Configuration;

/**
 * Server Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ServerProviderTest extends \PHPUnit_Framework_TestCase
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
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $container = new Container(new ReflectionContainer);

        $config = new Configuration;

        $middlewares = array();

        $middlewares[] = 'Zapheus\Fixture\Http\Middlewares\JsonMiddleware';
        $middlewares[] = 'Zapheus\Fixture\Http\Middlewares\FinalMiddleware';

        $config->set('app.middlewares', $middlewares);

        $server = array();

        $server['REQUEST_METHOD'] = 'GET';
        $server['REQUEST_URI'] = '/';
        $server['SERVER_NAME'] = 'rougin.github.io';
        $server['SERVER_PORT'] = 8000;

        $config->set('app.http.server', $server);

        $container->set(ServerProvider::CONFIG, $config);

        $this->container = $container;

        $this->provider = new ServerProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $message = new MessageProvider;

        $container = $message->register($this->container);

        $container = $this->provider->register($container);

        $dispatcher = $container->get(ServerProvider::DISPATCHER);

        $request = $container->get(MessageProvider::SERVER_REQUEST);

        $expected = array('application/json');

        $response = $dispatcher->dispatch($request);

        $result = $response->header('Content-Type');

        $this->assertEquals($expected, $result);
    }
}
