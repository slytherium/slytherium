<?php

namespace Slytherium\Provider;

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
     * @return \Slytherium\Container\WritableInterface
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
            $repository = 'Illuminate\Config\Repository';

            $illuminate = new Container;

            if (class_exists($repository) === true) {
                $config = $container->get(self::CONFIG);

                $items = $config->get('illuminate', array());

                $config = new $repository($items);

                $illuminate['config'] = $config;
            }
        }

        return $illuminate ?: $container->get($this->container);
    }
}
