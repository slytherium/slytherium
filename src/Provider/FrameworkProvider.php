<?php

namespace Zapheus\Provider;

use Zapheus\Container\CompositeContainer;
use Zapheus\Container\ContainerInterface;
use Zapheus\Container\SymfonyContainer;
use Zapheus\Container\WritableInterface;

/**
 * Framework Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FrameworkProvider implements ProviderInterface
{
    const ILLUMINATE_CONTAINER = 'Illuminate\Container\Container';

    const SILEX_CONTAINER = 'Pimple\Container';

    const SLYTHERIN_CONTAINER = 'Rougin\Slytherin\Container\Container';

    const SYMFONY_KERNEL = 'Zapheus\Provider\SymfonyKernel';

    /**
     * @var \Zapheus\Container\CompositeContainer
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
     * @param \Zapheus\Container\CompositeContainer|null $container
     */
    public function __construct(CompositeContainer $container = null)
    {
        $this->container = $container ?: new CompositeContainer;

        $this->externals[] = self::ILLUMINATE_CONTAINER;
        $this->externals[] = self::SILEX_CONTAINER;
        $this->externals[] = self::SLYTHERIN_CONTAINER;

        $this->wrappers[] = 'Zapheus\Bridge\Illuminate\Container';
        $this->wrappers[] = 'Zapheus\Container\PimpleContainer';
        $this->wrappers[] = 'Zapheus\Container\SlytherinContainer';
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
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
     * Returns the external container and wraps it to a Zapheus container.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @return void
     */
    protected function externals(ContainerInterface $container)
    {
        $containers = array_combine($this->externals, $this->wrappers);

        foreach ($containers as $external => $wrapper) {
            if (class_exists($wrapper) === true) {
                $contains = $container->has($external);

                $instance = new $external;

                $contains && $instance = $container->get($external);

                $this->container->add(new $wrapper($instance));
            }
        }
    }

    /**
     * Returns the instance from Symfony and wrap it into a SymfonyContainer.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    protected function symfony(ContainerInterface $container)
    {
        $kernel = $container->get(self::SYMFONY_KERNEL);

        $kernel->boot();

        $container = $kernel->getContainer();

        return new SymfonyContainer($container);
    }
}
