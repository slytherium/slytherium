<?php

namespace Slytherium\Provider;

use Slytherium\Container\CompositeContainer;
use Slytherium\Container\ContainerInterface;
use Slytherium\Container\SymfonyContainer;
use Slytherium\Container\WritableInterface;

/**
 * Framework Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FrameworkProvider implements ProviderInterface
{
    const ILLUMINATE_CONTAINER = 'Illuminate\Container\Container';

    const SILEX_CONTAINER = 'Pimple\Container';

    const SLYTHERIN_CONTAINER = 'Rougin\Slytherin\Container\Container';

    const SYMFONY_KERNEL = 'Slytherium\Provider\SymfonyKernel';

    /**
     * @var \Slytherium\Container\CompositeContainer
     */
    protected $container;

    /**
     * @var array
     */
    protected $externals = array();

    /**
     * @var array
     */
    protected $wrappers = array();

    /**
     * Initializes the container instance.
     *
     * @param \Slytherium\Container\CompositeContainer|null $container
     */
    public function __construct(CompositeContainer $container = null)
    {
        $this->container = $container ?: new CompositeContainer;

        $this->externals[] = self::ILLUMINATE_CONTAINER;
        $this->externals[] = self::SILEX_CONTAINER;
        $this->externals[] = self::SLYTHERIN_CONTAINER;

        $this->wrappers[] = 'Slytherium\Container\IlluminateContainer';
        $this->wrappers[] = 'Slytherium\Container\PimpleContainer';
        $this->wrappers[] = 'Slytherium\Container\SlytherinContainer';
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $this->container->add($container);

        $this->externals($container);

        if ($container->has(self::SYMFONY_KERNEL)) {
            $instance = $this->symfony($container);

            $this->container->add($instance);
        }

        return $this->container;
    }

    /**
     * Gets the external container and wraps it to a Slytherium container.
     *
     * @param  \Slytherium\Container\ContainerInterface $container
     * @return void
     */
    protected function externals(ContainerInterface $container)
    {
        $containers = array_combine($this->externals, $this->wrappers);

        foreach ($containers as $external => $wrapper) {
            $contains = $container->has($external);

            $instance = new $external;

            $contains && $instance = $container->get($external);

            $this->container->add(new $wrapper($instance));
        }
    }

    /**
     * Returns the instance from Symfony and wrap it into a Slytherium container.
     *
     * @param  \Slytherium\Container\ContainerInterface $container
     * @return \Slytherium\Container\ContainerInterface
     */
    protected function symfony(ContainerInterface $container)
    {
        $kernel = $container->get(self::SYMFONY_KERNEL);

        $kernel->boot();

        $container = $kernel->getContainer();

        return new SymfonyContainer($container);
    }
}
