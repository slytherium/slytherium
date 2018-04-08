<?php

namespace Zapheus\Http;

use Zapheus\Container\WritableInterface;
use Zapheus\Http\Server\Dispatcher;
use Zapheus\Provider\ProviderInterface;

/**
 * Server Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ServerProvider implements ProviderInterface
{
    const DISPATCHER = 'Zapheus\Http\Server\DispatcherInterface';

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(ProviderInterface::CONFIG);

        $middlewares = $config->get('app.middlewares', array());

        $dispatcher = new Dispatcher($middlewares, $container);

        return $container->set(self::DISPATCHER, $dispatcher);
    }
}
