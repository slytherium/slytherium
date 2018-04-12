<?php

namespace Zapheus\Http\Server;

use Zapheus\Container\WritableInterface;
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
    const BRIDGE_REQUEST = 'Zapheus\Bridge\Psr\Interop\ServerRequest';

    const DISPATCHER = 'Zapheus\Routing\DispatcherInterface';

    const PSR_REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const PSR_RESPONSE = 'Psr\Http\Message\ResponseInterface';

    const REQUEST = 'Zapheus\Http\Message\RequestInterface';

    const RESOLVER = 'Zapheus\Routing\ResolverInterface';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

    const ROUTE_ATTRIBUTE = 'zapheus-route';

    /**
     * @var array
     */
    protected $bridges = array();

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
        $this->container = $container;

        $psrs = array('Psr\Http\Message\ResponseInterface');

        $psrs[] = 'Psr\Http\Message\ServerRequestInterface';
        $psrs[] = 'Zapheus\Http\Message\RequestInterface';
        $psrs[] = 'Zapheus\Http\Message\ResponseInterface';

        $bridges = array('Zapheus\Bridge\Psr\Zapheus\Response');

        $bridges[] = 'Zapheus\Bridge\Psr\Zapheus\Request';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\ServerRequest';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\Response';

        $this->bridges = array_combine($psrs, $bridges);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        if (class_exists(self::BRIDGE_REQUEST) === true) {
            $psr = $this->bridge($request, self::REQUEST);

            $this->container->set(self::PSR_REQUEST, $psr);
        }

        if ($this->container->has(self::RESPONSE) === true) {
            $response = $this->container->get(self::RESPONSE);

            $psr = $this->bridge($response, self::RESPONSE);

            $this->container->set(self::PSR_RESPONSE, $psr);
        }

        $route = $this->dispatch($request);

        $result = $route ? $this->resolve($route) : null;

        return $this->response($result);
    }

    /**
     * Converts the specified instance into a bridge and vice versa.
     *
     * @param  \Zapheus\Http\Message\MessageInterface $object
     * @param  string                                 $interface
     * @return \Psr\Http\Message\MessageInterface
     */
    protected function bridge($object, $interface)
    {
        $exists = class_exists($this->bridges[$interface]);

        $bridge = $this->bridges[(string) $interface];

        $instanceof = is_a($object, (string) $interface);

        return $exists && $instanceof ? new $bridge($object) : $object;
    }

    /**
     * Dispatches against the provided HTTP method verb and URI.
     *
     * @param  string $method
     * @param  string $uri
     * @return \Zapheus\Routing\RouteInterface
     *
     * @throws \UnexpectedValueException
     */
    protected function dispatch(RequestInterface $request)
    {
        $route = $request->attribute(self::ROUTE_ATTRIBUTE);

        if ($route === null) {
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
        $result = $this->bridge($result, self::PSR_RESPONSE);

        $instanceof = $result instanceof ResponseInterface;

        $response = $this->container->get(self::RESPONSE);

        $instanceof || $response->stream()->write($result);

        return $instanceof ? $result : $response;
    }
}
