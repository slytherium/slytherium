<?php

namespace Zapheus\Fixture\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Food Service Provider
 *
 * @package Zapheus
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
        $food = 'Zapheus\Fixture\Http\Controllers\FoodController';

        $this->app->bind('food', $food);
    }
}
