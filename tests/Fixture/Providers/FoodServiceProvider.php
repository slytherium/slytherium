<?php

namespace Slytherium\Fixture\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Food Service Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FoodServiceProvider extends ServiceProvider
{
    /**
     * Registers the service provider.
     *
     * @return void
     */
    public function register()
    {
        $food = 'Slytherium\Fixture\Http\Controllers\FoodController';

        $this->app->bind('food', $food);
    }
}
