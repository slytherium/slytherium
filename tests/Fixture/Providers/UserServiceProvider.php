<?php

namespace Zapheus\Fixture\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Zapheus\Fixture\Http\Controllers\UserController;

/**
 * User Service Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UserServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param \Pimple\Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['user'] = new UserController;
    }
}
