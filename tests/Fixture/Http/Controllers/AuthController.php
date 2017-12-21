<?php

namespace Zapheus\Fixture\Http\Controllers;

/**
 * Auth Controller
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class AuthController
{
    /**
     * @var \Zapheus\Fixture\Http\Controllers\RoleController $role
     */
    protected $role;

    /**
     * Initializes the controller instance.
     *
     * @param \Zapheus\Fixture\Http\Controllers\RoleController $role
     */
    public function __construct(RoleController $role)
    {
        $this->role = $role;
    }
}
