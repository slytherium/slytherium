<?php

namespace Zapheus\Http\Server;

use Zapheus\Application;
use Zapheus\Container\WritableInterface;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Message\ResponseInterface;
use Zapheus\Ropebridge;
use Zapheus\Routing\Resolver;
use Zapheus\Routing\RouteInterface;

/**
 * Routing Handler
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class RoutingHandler implements HandlerInterface
{
    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Container\WritableInterface $container
     */
    public function __construct(WritableInterface $container)
    {
        $exists = $container->has(Application::RESPONSE) === true;

        if (class_exists(Ropebridge::BRIDGE_RESPONSE) && $exists)
        {
            $response = $container->get(Application::RESPONSE);

            $psr = Ropebridge::make($response, Application::RESPONSE);

            $container->set(Ropebridge::PSR_RESPONSE, $psr);
        }

        $this->container = $container;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        if (class_exists(Ropebridge::BRIDGE_REQUEST) === true)
        {
            $psr = Ropebridge::make($request, Application::REQUEST);

            $this->container->set(Ropebridge::PSR_REQUEST, $psr);
        }

        $route = $this->dispatch($request);

        $handler = new ResolverHandler($this->container, $route);

        if (count($route->middlewares()) > 0)
        {
            $middlewares = (array) $route->middlewares();

            $dispatcher = new Dispatcher($middlewares, $this->container);

            return $dispatcher->process($request, $handler);
        }

        return $handler->handle($request);
    }

    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Routing\RouteInterface
     */
    protected function dispatch(RequestInterface $request)
    {
        $route = $request->attribute(Application::ROUTE_ATTRIBUTE);

        if ($route instanceof RouteInterface)
        {
            return $route;
        }

        $dispatcher = $this->container->get(Application::DISPATCHER);

        $path = $request->uri()->path();

        return $dispatcher->dispatch($request->method(), $path);
    }
}
