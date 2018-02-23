<?php

namespace Zapheus\Application;

use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Server\ApplicationHandler;
use Zapheus\Http\Server\Dispatcher;

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
    protected $original;

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Application\ApplicationInterface|null $application
     */
    public function __construct(ApplicationInterface $application = null)
    {
        parent::__construct($application);

        $this->original = new Dispatcher;
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

        return $this->original->process($request, $handler);
    }
}
