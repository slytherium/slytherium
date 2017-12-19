<?php

namespace Slytherium\Fixture\Providers;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Symfony Simple Bundle
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonySimpleBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->set('simple', new SimpleController);
    }
}
