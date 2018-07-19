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
     * Initializes the resolver instance.
     *
     * @param \Zapheus\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Resolves the specified route instance.
     *
     * @param  \Zapheus\Routing\RouteInterface $route
     * @return mixed
     */
    public function resolve(RouteInterface $route)
    {
        $handler = $route->handler();

        is_string($handler) && $handler = explode('@', $handler);

        $parameters = (array) $route->parameters();

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
        $exists = class_exists($name) || interface_exists($name);

        $default = $this->default($parameter, $value);

        return ! $value && $exists ? $this->instance($name) : $value;
    }

    /**
     * Resolves the specified parameters from a container.
     *
     * @param  \ReflectionFunctionAbstract $reflection
     * @param  array                       $parameters
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
     * Returns the default value of a specified parameter.
     *
     * @param  \ReflectionParameter $parameter
     * @param  mixed                $value
     * @return mixed
     */
    protected function default(\ReflectionParameter $parameter, $value)
    {
        $default = $parameter->isDefaultValueAvailable() && $value === null;

        return $default === true ? $parameter->getDefaultValue() : $value;
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

            $instance = new \ReflectionMethod($class, $method);

            $handler = array($this->instance($class), $method);

            return array((array) $handler, $instance);
        }

        $instance = new \ReflectionFunction($handler);

        return array($handler, $instance);
    }
}
