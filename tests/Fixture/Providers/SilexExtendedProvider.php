<?php

namespace Slytherium\Fixture\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slytherium\Fixture\Http\Controllers\ExtendedController;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Silex Extended Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SilexExtendedProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param \Pimple\Container $pimple
     */
    public function register(Container $pimple)
    {
        $simple = $pimple['simple'] ?: new SimpleController;

        $pimple['extended'] = new ExtendedController($simple);
    }
}
