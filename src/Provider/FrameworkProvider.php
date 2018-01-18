<?php

namespace Zapheus\Provider;

use Zapheus\Bridge\Symfony\Container;
use Zapheus\Container\CompositeContainer;
use Zapheus\Container\ContainerInterface;
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

    const SYMFONY_KERNEL = 'Zapheus\Bridge\Symfony\Kernel';

    /**
     * @var \Zapheus\Container\CompositeContainer
     */
    protected $container;

    /**
     * @var array
     */
    protected $externals = array('Rougin\Slytherin\Container\Container');

    /**
     * @var array
     */
    protected $wrappers = array('Zapheus\Bridge\Slytherin\Container');

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

        $this->wrappers[] = 'Zapheus\Bridge\Illuminate\Container';

        $this->wrappers[] = 'Zapheus\Bridge\Silex\Container';
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

        if ($container->has(self::SYMFONY_KERNEL) === true) {
            $kernel = $container->get(self::SYMFONY_KERNEL);

            $kernel->boot();

            $container = $kernel->getContainer();

            $this->container->add(new Container($container));
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
        $items = array_combine($this->externals, $this->wrappers);

        foreach ($items as $external => $wrapper) {
            if (class_exists($external) === true) {
                $object = $container->get($external);

                $instance = new $wrapper($object);

                $this->container->add($instance);
            }
        }
    }
}
