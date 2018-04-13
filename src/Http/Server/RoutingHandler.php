<?php

namespace Zapheus\Http\Server;

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
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingHandler implements HandlerInterface
{
    const DISPATCHER = 'Zapheus\Routing\DispatcherInterface';

    const REQUEST = 'Zapheus\Http\Message\RequestInterface';

    const RESOLVER = 'Zapheus\Routing\ResolverInterface';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

    const ROUTE_ATTRIBUTE = 'zapheus-route';

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
        $exists = $container->has(self::RESPONSE);

        if (class_exists(Ropebridge::BRIDGE_RESPONSE) && $exists) {
            $response = $container->get(self::RESPONSE);

            $psr = Ropebridge::make($response, self::RESPONSE);

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
        if (class_exists(Ropebridge::BRIDGE_REQUEST) === true) {
            $psr = Ropebridge::make($request, self::REQUEST);

            $this->container->set(Ropebridge::PSR_REQUEST, $psr);
        }

        $route = $this->dispatch($request);

        $result = $route ? $this->resolve($route) : null;

        return $this->response($result);
    }

    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Routing\RouteInterface|null
     */
    protected function dispatch(RequestInterface $request)
    {
        $route = $request->attribute(self::ROUTE_ATTRIBUTE);

        if ($route instanceof RouteInterface === false) {
            $dispatcher = $this->container->get(self::DISPATCHER);

            $path = (string) $request->uri()->path();

            $method = (string) $request->method();

            return $dispatcher->dispatch($method, $path);
        }

        return $route;
    }

    /**
     * Resolves the route instance using a resolver.
     *
     * @param  \Zapheus\Routing\RouteInterface $route
     * @return mixed
     */
    protected function resolve(RouteInterface $route)
    {
        if ($this->container->has(self::RESOLVER)) {
            $result = $this->container->get(self::RESOLVER);

            return $result->resolve($route);
        }

        $resolver = new Resolver($this->container);

        return $resolver->resolve($route);
    }

    /**
     * Converts the given result into a ResponseInterface.
     *
     * @param  mixed $result
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    protected function response($result)
    {
        $result = Ropebridge::make($result, Ropebridge::PSR_RESPONSE);

        $instanceof = $result instanceof ResponseInterface;

        $response = $this->container->get(self::RESPONSE);

        $instanceof || $response->stream()->write($result);

        return $instanceof === true ? $result : $response;
    }
}
