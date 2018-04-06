<?php

namespace Zapheus\Routing;

use Zapheus\Application\ApplicationInterface;
use Zapheus\Container\WritableInterface;
use Zapheus\Provider\ProviderInterface;

/**
 * Routing Provider
 *
 * @package App
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingProvider implements ProviderInterface
{
    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(ProviderInterface::CONFIG);

        $router = $config->get('app.router', new Router);

        is_string($router) && $router = $container->get($router);

        $dispatcher = new Dispatcher($router);

        $interface = ApplicationInterface::DISPATCHER;

        return $container->set($interface, $dispatcher);
    }
}
