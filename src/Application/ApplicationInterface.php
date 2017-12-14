<?php

namespace Slytherium\Application;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Application Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ApplicationInterface
{
    /**
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request);

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Rougin\Slytherin\Http\Message\StreamInterface
     */
    public function run();
}
