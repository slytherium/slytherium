<?php

namespace Slytherium\Fixture\Providers;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Slytherin Role Bundle
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinRoleBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $role = 'Slytherium\Fixture\Http\Controllers\RoleController';

        $container->register('role', $role);
    }
}
