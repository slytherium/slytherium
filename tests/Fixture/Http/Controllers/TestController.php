<?php

namespace Slytherium\Fixture\Http\Controllers;

/**
 * Test Controller
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TestController
{
    /**
     * @var \Slytherium\Fixture\Http\Controllers\FoodController $food
     */
    protected $food;

    /**
     * Initializes the controller instance.
     *
     * @param \Slytherium\Fixture\Http\Controllers\FoodController $food
     */
    public function __construct(FoodController $food)
    {
        $this->food = $food;
    }
}
