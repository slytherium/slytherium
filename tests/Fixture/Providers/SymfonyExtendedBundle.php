<?php

namespace Slytherium\Fixture\Providers;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Symfony Extended Bundle
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyExtendedBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $extended = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $definition = $container->register('extended', $extended);

        $definition->setArgument('$controller', new Reference('simple'));
    }
}
