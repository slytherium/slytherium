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
     * @var \Zapheus\Routing\RouterInterface
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
     * Adds a new Route instance in CONNECT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function connect($uri, $handler)
    {
        $route = new Route('CONNECT', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in DELETE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function delete($uri, $handler)
    {
        $route = new Route('DELETE', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in GET HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function get($uri, $handler)
    {
        $route = new Route('GET', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in HEAD HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function head($uri, $handler)
    {
        $route = new Route('HEAD', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in OPTIONS HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function options($uri, $handler)
    {
        $route = new Route('OPTIONS', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in PATCH HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function patch($uri, $handler)
    {
        $route = new Route('PATCH', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in POST HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function post($uri, $handler)
    {
        $route = new Route('POST', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in PURGE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function purge($uri, $handler)
    {
        $route = new Route('PURGE', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in PUT HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function put($uri, $handler)
    {
        $route = new Route('PUT', $uri, $handler);

        return $this->router->add($route);
    }

    /**
     * Adds a new Route instance in TRACE HTTP method.
     *
     * @param  string          $uri
     * @param  string|callable $handler
     * @return self
     */
    public function trace($uri, $handler)
    {
        $route = new Route('TRACE', $uri, $handler);

        return $this->router->add($route);
    }
}
