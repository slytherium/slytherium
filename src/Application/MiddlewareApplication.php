<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Server\ApplicationHandler;
use Zapheus\Http\Server\Dispatcher;
use Zapheus\Http\Server\MiddlewareInterface;

/**
 * Middleware Application
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MiddlewareApplication extends AbstractApplication
{
    /**
     * @var \Zapheus\Http\Server\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Application|null $application
     */
    public function __construct(Application $application = null)
    {
        parent::__construct($application);

        $this->dispatcher = new Dispatcher;
    }

    /**
     * Handles the Request to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $handler = new ApplicationHandler($this->application);

        return $this->dispatcher->process($request, $handler);
    }

    /**
     * Adds a new middleware to the stack.
     *
     * @param  mixed $middleware
     * @return self
     */
    public function pipe($middleware)
    {
        return $this->dispatcher->pipe($middleware);
    }
}
