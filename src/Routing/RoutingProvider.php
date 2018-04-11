<?php

namespace Zapheus\Routing;

use Zapheus\Container\WritableInterface;
use Zapheus\Http\Server\RoutingHandler;
use Zapheus\Provider\ProviderInterface;

/**
 * Routing Provider
 *
 * @package App
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingProvider implements ProviderInterface
{
    const ROUTER = 'Zapheus\Routing\RouterInterface';

    /**
     * @var \Zapheus\Routing\RouterInterface
     */
    protected $router;

    /**
     * Initializes the provider instance.
     *
     * @param \Zapheus\Routing\RouterInterface|null $router
     */
    public function __construct(RouterInterface $router = null)
    {
        $this->router = $router === null ? new Router : $router;
    }
    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(ProviderInterface::CONFIG);

        $interface = RoutingHandler::DISPATCHER;

        if ($container->has(self::ROUTER) === false) {
            $router = $config->get('app.router', $this->router);

            $router = is_string($router) ? $container->get($router) : $router;

            $dispatcher = new Dispatcher($router);

            return $container->set($interface, $dispatcher);
        }

        $dispatcher = new Dispatcher($container->get(self::ROUTER));

        return $container->set($interface, $dispatcher);
    }
}
