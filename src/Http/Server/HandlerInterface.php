<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Handler Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface HandlerInterface
{
    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request);
}
