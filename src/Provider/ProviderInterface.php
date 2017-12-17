<?php

namespace Slytherium\Provider;

use Slytherium\Container\WritableInterface;

/**
 * Provider Interface
 *
 * TODO: Support service providers from other frameworks:
 * - https://silex.symfony.com/doc/2.0/providers.html
 * - https://laravel.com/docs/5.5/providers
 * - https://symfony.com/doc/current/bundles.html
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ProviderInterface
{
    const CONFIG = 'Slytherium\Provider\ConfigurationInterface';

    /**
     * Registers the bindings in the container.
     *
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\ContainerInterface
     */
    public function register(WritableInterface $container);
}
