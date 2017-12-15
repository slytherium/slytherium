<?php

namespace Slytherium\Provider;

use Illuminate\Config\Repository;
use Slytherium\Container\WritableInterface;
use Slytherium\Provider\Illuminate\Container;

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

        $container->set(get_class($illuminate), $illuminate);

        return $container->delegate($illuminate);
    }

    /**
     * Returns a \Illuminate\Container\Container instance.
     *
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Illuminate\Container\Container
     */
    protected function container(WritableInterface $container)
    {
        $class = 'Slytherium\Provider\Illuminate\Container';

        $illuminate = null;

        if ($container->has($class) === false) {
            $illuminate = new Container;

            if ($container->has(self::CONFIG) === true) {
                $config = $container->get(self::CONFIG);

                $items = $config->get('illuminate', array());

                $illuminate['config'] = new Repository($items);
            }
        }

        return $illuminate ?: $container->get($class);
    }
}
