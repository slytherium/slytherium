<?php

namespace Slytherium\Fixture\Providers;

use Illuminate\Support\ServiceProvider;
use Slytherium\Fixture\Http\Controllers\SimpleController;

/**
 * Illuminate Simple Service Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class IlluminateSimpleServiceProvider extends ServiceProvider
{
    /**
     * Registers the service provider.
     *
     * @return void
     */
    public function register()
    {
        $simple = 'Slytherium\Fixture\Http\Controllers\SimpleController';

        $this->app->bind('simple', $simple);
    }
}
