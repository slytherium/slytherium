<?php

namespace Zapheus\Provider;

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

    const SLYTHERIN_CONTAINER = 'Rougin\Slytherin\Container\Container';

    const SYMFONY_CONTAINER = 'Symfony\Component\DependencyInjection\Container';

    /**
     * @var \Zapheus\Container\CompositeContainer
     */
    protected $container;

    /**
     * @var array
     */
    protected $keys = array();

    /**
     * @var array
     */
    protected $values = array();

    /**
     * Initializes the container instance.
     *
     * @param \Zapheus\Container\CompositeContainer|null $container
     */
    public function __construct(CompositeContainer $container = null)
    {
        $this->container = $container ?: new CompositeContainer;

        $this->keys[] = self::ILLUMINATE_CONTAINER;

        $this->keys[] = self::SILEX_CONTAINER;

        $this->keys[] = self::SLYTHERIN_CONTAINER;

        $this->keys[] = self::SYMFONY_CONTAINER;

        $this->values[] = 'Zapheus\Bridge\Illuminate\Container';

        $this->values[] = 'Zapheus\Bridge\Silex\Container';

        $this->values[] = 'Zapheus\Bridge\Slytherin\Container';

        $this->values[] = 'Zapheus\Bridge\Symfony\Container';
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

        $items = array_combine($this->keys, $this->values);

        foreach ($items as $external => $wrapper) {
            if (class_exists($external) === true) {
                $object = $container->get($external);

                $instance = new $wrapper($object);

                $this->container->add($instance);
            }
        }

        return $this->container;
    }
}
