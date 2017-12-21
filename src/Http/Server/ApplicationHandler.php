<?php

namespace Zapheus\Http\Server;

use Zapheus\Application;
use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Application Handler
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApplicationHandler implements HandlerInterface
{
    /**
     * @var \Zapheus\Application
     */
    protected $application;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        return $this->application->handle($request);
    }
}
