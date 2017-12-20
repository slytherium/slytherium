<?php

namespace Slytherium\Fixture\Http\Controllers;

/**
 * Blog Controller
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BlogController
{
    /**
     * @var \Slytherium\Fixture\Http\Controllers\UserController $user
     */
    protected $user;

    /**
     * Initializes the controller instance.
     *
     * @param \Slytherium\Fixture\Http\Controllers\UserController $user
     */
    public function __construct(UserController $user)
    {
        $this->user = $user;
    }
}
