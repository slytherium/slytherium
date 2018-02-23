<?php

namespace Zapheus\Application;

use Zapheus\Http\Message\RequestInterface;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Router;

/**
 * Router Application
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterApplication extends AbstractApplication
{
    /**
     * @var \Zapheus\Routing\RouterInterface
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

        $this->original = new Router;
    }

    /**
     * Handles the Request to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $interface = ApplicationInterface::DISPATCHER;

        $dispatcher = new Dispatcher($this->original);

        $this->application->set($interface, $dispatcher);

        return $this->application->handle($request);
    }
}
