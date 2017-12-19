<?php

namespace Slytherium\Fixture\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Silex Simple Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SilexSimpleProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param \Pimple\Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['simple'] = new SimpleController;
    }
}
