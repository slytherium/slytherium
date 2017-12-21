<?php

namespace Zapheus\Provider;

use Zapheus\Container\WritableInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Zapheus\Provider\SymfonyKernel;

/**
 * Symfony Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyProvider implements ProviderInterface
{
    const KERNEL = 'Zapheus\Provider\SymfonyKernel';

    /**
     * @var \Symfony\Component\HttpKernel\Bundle\BundleInterface
     */
    protected $bundle;

    /**
     * Initializes the provider instance.
     *
     * @param \Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     */
    public function __construct(BundleInterface $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        if ($container->has(self::KERNEL) === true) {
            $kernel = $container->get(self::KERNEL);

            $kernel->add($this->bundle);

            return $container->set(self::KERNEL, $kernel);
        }

        $configuration = $container->get(ProviderInterface::CONFIG);

        $kernel = new SymfonyKernel($configuration);

        $kernel->add($this->bundle);

        return $container->set(self::KERNEL, $kernel);
    }
}
