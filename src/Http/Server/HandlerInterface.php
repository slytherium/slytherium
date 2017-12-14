<?php

namespace Slytherium\Http\Server;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Handler Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface HandlerInterface
{
    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request);
}
