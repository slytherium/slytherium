<?php

namespace Slytherium\Provider;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Slytherium\Container\WritableInterface;

/**
 * Illuminate Provider
 *
 * @package Slytherium
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
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\ContainerInterface
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
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Illuminate\Container\Container
     */
    protected function container(WritableInterface $container)
    {
        $illuminate = null;

        if ($container->has($this->container) === false) {
            $loader = 'Illuminate\Config\LoaderInterface';

            $illuminate = new Container;

            if (interface_exists($loader) === false) {
                $config = $container->get(self::CONFIG);

                $items = $config->get('illuminate', array());

                $illuminate['config'] = new Repository($items);
            }
        }

        return $illuminate ?: $container->get($this->container);
    }
}
