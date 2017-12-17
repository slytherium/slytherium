<?php

namespace Slytherium\Provider;

use Slytherium\Container\WritableInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Slytherium\Provider\Symfony\Kernel;

/**
 * Symfony Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyProvider implements ProviderInterface
{
    const KERNEL = 'Slytherium\Provider\Symfony\Kernel';

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
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        if ($container->has(self::KERNEL)) {
            $kernel = $container->get(self::KERNEL);
        } else {
            $configuration = $container->get(ProviderInterface::CONFIG);

            $kernel = new Kernel($configuration);
        }

        $kernel->add($this->bundle);

        return $container->set(self::KERNEL, $kernel);
    }
}
