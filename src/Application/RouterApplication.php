<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Routing\Dispatcher;
use Zapheus\Routing\Route;
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
     * @var \Zapheus\Routing\Router
     */
    protected $router;

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Application|null $application
     */
    public function __construct(Application $application = null)
    {
        parent::__construct($application);

        $this->router = new Router;
    }

    /**
     * Handles the Request to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $dispatcher = new Dispatcher($this->router);

        $this->application->set(Application::DISPATCHER, $dispatcher);

        return $this->application->handle($request);
    }

    /**
     * Adds a new route instance in CONNECT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function connect($uri, $handler)
    {
        return $this->router->connect($uri, $handler);
    }

    /**
     * Adds a new route instance in DELETE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function delete($uri, $handler)
    {
        return $this->router->delete($uri, $handler);
    }

    /**
     * Adds a new route instance in GET HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function get($uri, $handler)
    {
        return $this->router->get($uri, $handler);
    }

    /**
     * Adds a new route instance in HEAD HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function head($uri, $handler)
    {
        return $this->router->head($uri, $handler);
    }

    /**
     * Adds a new route instance in OPTIONS HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function options($uri, $handler)
    {
        return $this->router->options($uri, $handler);
    }

    /**
     * Adds a new route instance in PATCH HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function patch($uri, $handler)
    {
        return $this->router->patch($uri, $handler);
    }

    /**
     * Adds a new route instance in POST HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function post($uri, $handler)
    {
        return $this->router->post($uri, $handler);
    }

    /**
     * Adds a new route instance in PURGE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function purge($uri, $handler)
    {
        return $this->router->purge($uri, $handler);
    }

    /**
     * Adds a new route instance in PUT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function put($uri, $handler)
    {
        return $this->router->put($uri, $handler);
    }

    /**
     * Adds a new route instance in TRACE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function trace($uri, $handler)
    {
        return $this->router->trace($uri, $handler);
    }
}
