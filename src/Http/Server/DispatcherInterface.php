<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Dispatcher Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface DispatcherInterface extends MiddlewareInterface
{
    /**
     * Dispatches the defined middleware stack.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request);

    /**
     * Adds a new middleware to the stack.
     *
     * @param  mixed $middleware
     * @return self
     */
    public function pipe($middleware);
}
