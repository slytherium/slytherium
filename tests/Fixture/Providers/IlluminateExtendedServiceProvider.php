<?php

namespace Slytherium\Fixture\Providers;

use Illuminate\Support\ServiceProvider;
use Slytherium\Fixture\Http\Controllers\ExtendedController;

/**
 * Illuminate Extended Service Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateExtendedServiceProvider extends ServiceProvider
{
    /**
     * Registers the service provider.
     *
     * @return void
     */
    public function register()
    {
        $extended = 'Slytherium\Fixture\Http\Controllers\ExtendedController';

        $this->app->bind('extended', $extended);
    }
}
