<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\ApplicationHandler;
use Slytherium\Http\Server\Dispatcher;
use Slytherium\Http\Server\MiddlewareInterface;

/**
 * Middleware Application
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MiddlewareApplication extends AbstractApplication
{
    /**
     * @var \Slytherium\Http\Server\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Initializes the application instance.
     *
     * @param \Slytherium\Application|null $application
     */
    public function __construct(Application $application = null)
    {
        parent::__construct($application);

        $this->dispatcher = new Dispatcher;
    }

    /**
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $handler = new ApplicationHandler($this->application);

        return $this->dispatcher->process($request, $handler);
    }

    /**
     * Adds a new middleware to the stack.
     *
     * @param  \Slytherium\Http\Server\MiddlewareInterface $middleware
     * @return self
     */
    public function pipe(MiddlewareInterface $middleware)
    {
        return $this->dispatcher->pipe($middleware);
    }
}
