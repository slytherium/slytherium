<?php

namespace Slytherium\Fixture\Http\Controllers;

/**
 * Extended Controller
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ExtendedController
{
    /**
     * @var \Slytherium\Fixture\Http\Controllers\SimpleController
     */
    protected $controller;

    /**
     * Initializes the controller instance.
     *
     * @param \Slytherium\Fixture\Http\Controllers\SimpleController $controller
     */
    public function __construct(SimpleController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Returns the text "Hello, world".
     *
     * @return string
     */
    public function greet()
    {
        $text = $this->controller->greet();

        return $text . ' and people';
    }
}
