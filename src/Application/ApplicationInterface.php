<?php

namespace Zapheus\Application;

use Zapheus\Http\Message\RequestInterface;

/**
 * Application Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ApplicationInterface
{
    /**
     * Handles the Request to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request);
}
