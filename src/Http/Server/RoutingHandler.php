<?php

namespace Zapheus\Http\Server;

use Zapheus\Container\ContainerInterface;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Message\ResponseInterface;
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

    const PSR_BRIDGE = 'Zapheus\Bridge\Psr\Zapheus\Response';

    const PSR_RESPONSE = 'Psr\Http\Message\ResponseInterface';

    const RESOLVER = 'Zapheus\Routing\ResolverInterface';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

    const ROUTE_ATTRIBUTE = 'zapheus-route';

    /**
     * @var \Zapheus\Container\ContainerInterface
     */
    protected $container;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
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
        $route = $request->attribute(self::ROUTE_ATTRIBUTE);

        if ($this->container->has(self::DISPATCHER) && $route === null) {
            $dispatcher = $this->container->get(self::DISPATCHER);

            $path = (string) $request->uri()->path();

            $method = (string) $request->method();

            $route = $dispatcher->dispatch($method, $path);
        }

        $result = $route ? $this->resolve($route) : null;

        return $this->response($result);
    }

    /**
     * Resolves the route instance using a resolver.
     *
     * @param  \Zapheus\Routing\RouteInterface $route
     * @return mixed
     */
    protected function resolve(RouteInterface $route)
    {
        if ($this->container->has(self::RESOLVER) === false) {
            $resolver = new Resolver($this->container);

            return $resolver->resolve($route);
        }

        $resolver = $this->container->get(self::RESOLVER);

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
        if (is_a($result, self::PSR_RESPONSE) === true) {
            $reflection = new \ReflectionClass(self::PSR_BRIDGE);

            $arguments = array('response' => $result);

            $result = $reflection->newInstanceArgs($arguments);
        }

        $instanceof = $result instanceof ResponseInterface;

        $response = $this->container->get(self::RESPONSE);

        $instanceof || $response->stream()->write($result);

        return $instanceof ? $result : $response;
    }
}
