<?php

namespace Zapheus\Routing;

use Zapheus\Application;
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
        if ($container->has(Application::ROUTER) === false) {
            $config = $container->get(ProviderInterface::CONFIG);

            $router = $config->get('app.router', $this->router);

            is_string($router) && $router = $container->get($router);

            $dispatcher = new Dispatcher($router);

            return $container->set(Application::DISPATCHER, $dispatcher);
        }

        $dispatcher = new Dispatcher($container->get(Application::ROUTER));

        return $container->set(Application::DISPATCHER, $dispatcher);
    }
}
