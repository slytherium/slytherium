<?php

namespace Zapheus\Http\Server;

use Zapheus\Application\ApplicationInterface;
use Zapheus\Http\Message\RequestInterface;

/**
 * Application Handler
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ApplicationHandler implements HandlerInterface
{
    /**
     * @var \Zapheus\Application\ApplicationInterface
     */
    protected $application;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Application\ApplicationInterface $application
     */
    public function __construct(ApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        return $this->application->handle($request);
    }
}
