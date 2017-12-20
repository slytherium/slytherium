<?php

namespace Slytherium\Fixture\Http\Controllers;

/**
 * Laud Controller
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class LaudController
{
    /**
     * @var \Slytherium\Fixture\Http\Controllers\HailController
     */
    protected $hail;

    /**
     * Initializes the controller instance.
     *
     * @param \Slytherium\Fixture\Http\Controllers\HailController $hail
     */
    public function __construct(HailController $hail)
    {
        $this->hail = $hail;
    }

    /**
     * Returns the text "Hello, world".
     *
     * @return string
     */
    public function greet()
    {
        $text = $this->hail->greet();

        return $text . ' and people';
    }
}
