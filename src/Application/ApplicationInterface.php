<?php

namespace Zapheus\Application;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Application Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ApplicationInterface
{
    /**
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request);
}
