<?php

namespace Slytherium\Provider;

use Slytherium\Container\CompositeContainer;
use Slytherium\Container\ContainerInterface;
use Slytherium\Container\WritableInterface;
use Slytherium\Provider\Symfony\Container as SymfonyContainer;

/**
 * Framework Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FrameworkProvider implements ProviderInterface
{
    /**
     * @var \Slytherium\Container\CompositeContainer
     */
    protected $container;

    /**
     * Initializes the container instance.
     *
     * @param \Slytherium\Container\CompositeContainer|null $container
     */
    public function __construct(CompositeContainer $container = null)
    {
        $this->container = $container ?: new CompositeContainer;
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

        $kernel = 'Slytherium\Provider\Symfony\Kernel';

        if ($container->has($kernel) === true) {
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
        list($externals, $wrappers) = array(array(), array());

        $externals[] = 'Illuminate\Container\Container';
        $externals[] = 'Rougin\Slytherin\Container\Container';

        $wrappers[] = 'Slytherium\Provider\Illuminate\Container';
        $wrappers[] = 'Slytherium\Provider\Slytherin\Container';

        $containers = array_combine($externals, $wrappers);

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
        $kernel = $container->get('Slytherium\Provider\Symfony\Kernel');

        $kernel->boot();

        return new SymfonyContainer($kernel->getContainer());
    }
}
