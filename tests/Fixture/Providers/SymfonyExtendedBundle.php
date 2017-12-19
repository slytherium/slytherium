<?php

namespace Slytherium\Fixture\Providers;

use Slytherium\Fixture\Http\Controllers\ExtendedController;
use Slytherium\Fixture\Http\Controllers\SimpleController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
        $simple = new SimpleController;

        $extended = new ExtendedController($simple);

        $container->set('extended', $extended);
    }
}
