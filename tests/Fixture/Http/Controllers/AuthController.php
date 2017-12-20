<?php

namespace Slytherium\Fixture\Http\Controllers;

/**
 * Auth Controller
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class AuthController
{
    /**
     * @var \Slytherium\Fixture\Http\Controllers\RoleController $role
     */
    protected $role;

    /**
     * Initializes the controller instance.
     *
     * @param \Slytherium\Fixture\Http\Controllers\RoleController $role
     */
    public function __construct(RoleController $role)
    {
        $this->role = $role;
    }
}
