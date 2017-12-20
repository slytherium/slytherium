<?php

namespace Slytherium\Fixture\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Test Service Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestServiceProvider extends ServiceProvider
{
    /**
     * Registers the service provider.
     *
     * @return void
     */
    public function register()
    {
        $test = 'Slytherium\Fixture\Http\Controllers\TestController';

        $this->app->bind('test', $test);
    }
}
