<?php

namespace Slytherium\Provider;

use Slytherium\Container\WritableInterface;

/**
 * Provider Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Defines the specified integration.
     *
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\WritableInterface
     */
    public function register(WritableInterface $container);
}
