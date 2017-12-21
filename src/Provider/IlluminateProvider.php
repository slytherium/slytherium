<?php

namespace Zapheus\Provider;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Zapheus\Container\WritableInterface;

/**
 * Illuminate Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateProvider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $container = 'Illuminate\Container\Container';

    /**
     * @var string
     */
    protected $provider;

    /**
     * Initializes the provider instance.
     *
     * @param string $provider
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $illuminate = $this->container($container);

        $provider = new $this->provider($illuminate);

        $provider->register();

        $container->set($this->container, $illuminate);

        return $container;
    }

    /**
     * Returns a \Illuminate\Container\Container instance.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Illuminate\Container\Container
     */
    protected function container(WritableInterface $container)
    {
        if ($container->has($this->container) === false) {
            $loader = 'Illuminate\Config\LoaderInterface';

            $illuminate = new Container;

            if (interface_exists($loader) === false) {
                $config = $container->get(self::CONFIG);

                $items = $config->get('illuminate', array());

                $illuminate['config'] = new Repository($items);
            }

            return $illuminate;
        }

        return $container->get($this->container);
    }
}
