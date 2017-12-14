<?php

namespace Slytherium\Http\Server;

use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Application Handler
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApplicationHandler implements HandlerInterface
{
    /**
     * @var \Slytherium\Application
     */
    protected $application;

    /**
     * Initializes the handler instance.
     *
     * @param \Slytherium\Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        return $this->application->handle($request);
    }
}
