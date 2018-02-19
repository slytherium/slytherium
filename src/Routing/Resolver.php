<?php

namespace Zapheus\Routing;

use Zapheus\Container\ContainerInterface;

/**
 * Resolver
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Resolver implements ResolverInterface
{
    /**
     * @var \Zapheus\Container\ContainerInterface
     */
    protected $container;

    /**
     * Resolves the specified handler against a container instance.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @param  \Zapheus\Routing\RouteInterface       $route
     * @return mixed
     */
    public function resolve(ContainerInterface $container, RouteInterface $route)
    {
        $this->container = $container;

        $handler = $route->handler();

        is_string($handler) && $handler = explode('@', $handler);

        $middlewares = $route->middlewares();

        $parameters = $route->parameters();

        list($handler, $reflection) = $this->reflection($handler);

        $parameters = $this->arguments($reflection, $parameters);

        return call_user_func_array($handler, $parameters);
    }

    /**
     * Returns an argument based on the given parameter.
     *
     * @param  \ReflectionParameter $parameter
     * @param  string               $name
     * @param  mixed                $value
     * @return mixed|null
     */
    protected function argument(\ReflectionParameter $parameter, $name, $value)
    {
        $default = $parameter->isDefaultValueAvailable() && $value === null;

        $default && $value = $parameter->getDefaultValue();

        return $value === null ? $this->instance($name) : $value;
    }

    /**
     * Resolves the specified parameters from a container.
     *
     * @param  \ReflectionFunctionAbstract $reflection
     * @return array
     */
    protected function arguments(\ReflectionFunctionAbstract $reflection, $parameters = array())
    {
        $arguments = array();

        foreach ($reflection->getParameters() as $key => $parameter) {
            $class = $parameter->getClass();

            $name = $class !== null ? $class->getName() : $parameter->getName();

            $default = isset($parameters[$name]) ? $parameters[$name] : null;

            $arguments[$name] = $this->argument($parameter, $name, $default);
        }

        return $arguments;
    }

    /**
     * Returns the instance of the identifier from the container.
     *
     * @param  string $class
     * @return mixed
     */
    protected function instance($class)
    {
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        $exists = $this->container->has($class);

        if ($exists === false && $constructor !== null) {
            $arguments = $this->arguments($constructor);

            return $reflection->newInstanceArgs($arguments);
        }

        return $this->container->get($class);
    }

    /**
     * Returns a ReflectionFunctionAbstract instance.
     *
     * @param  array|callable $handler
     * @return \ReflectionFunctionAbstract
     */
    protected function reflection($handler)
    {
        if (is_array($handler) === true) {
            list($class, $method) = (array) $handler;

            $reflection = new \ReflectionMethod($class, $method);

            $handler = array($this->instance($class), $method);

            return array((array) $handler, $reflection);
        }

        $reflection = new \ReflectionFunction($handler);

        return array($handler, $reflection);
    }
}
