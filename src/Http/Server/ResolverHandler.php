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
 * Resolver Handler
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ResolverHandler implements HandlerInterface
{
    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Routing\RouteInterface
     */
    protected $route;

    /**
     * Initializes the handler instance.
     *
     * @param \Zapheus\Container\WritableInterface $resolver
     * @param \Zapheus\Routing\RouteInterface      $route
     */
    public function __construct(WritableInterface $container, RouteInterface $route)
    {
        $this->container = $container;

        $this->route = $route;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        if ($this->container->has(Application::RESOLVER) === true) {
            $resolver = $this->container->get(Application::RESOLVER);

            return $this->response($resolver->resolve($this->route));
        }

        $resolver = new Resolver($this->container);

        $result = $resolver->resolve($this->route);

        return $this->response($result);
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

        $response = $this->container->get(Application::RESPONSE);

        $instanceof || $response->stream()->write($result);

        return $instanceof === true ? $result : $response;
    }
}
