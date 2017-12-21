<?php

namespace Zapheus\Fixture\Http\Controllers;

/**
 * Blog Controller
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BlogController
{
    /**
     * @var \Zapheus\Fixture\Http\Controllers\UserController $user
     */
    protected $user;

    /**
     * Initializes the controller instance.
     *
     * @param \Zapheus\Fixture\Http\Controllers\UserController $user
     */
    public function __construct(UserController $user)
    {
        $this->user = $user;
    }
}
