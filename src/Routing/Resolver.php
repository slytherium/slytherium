<?php

namespace Zapheus\Routing;

use Zapheus\Container\ContainerInterface;

/**
 * Resolver
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * Resolves the specified parameters from a container.
     *
     * @param  \ReflectionFunctionAbstract $reflection
     * @param  array                       $parameters
     * @return array
     */
    protected function arguments(\ReflectionFunctionAbstract $reflection, $parameters = array())
    {
        $arguments = array();

        foreach ($reflection->getParameters() as $key => $parameter)
        {
            $class = $parameter->getClass();

            $name = $parameter->getName();

            if ($class)
            {
                $name = $class->getName();
            }

            if (isset($parameters[$name]))
            {
                $value = $parameters[$name];

                $default = $this->value($parameter, $value);

                $arguments[$name] = $default;

                continue;
            }

            $arguments[$name] = $this->instance($name);
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

        if ($exists === false && $constructor !== null)
        {
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
        if (is_array($handler) === true)
        {
            list($class, $method) = (array) $handler;

            $instance = new \ReflectionMethod($class, $method);

            $handler = array($this->instance($class), $method);

            return array((array) $handler, $instance);
        }

        $instance = new \ReflectionFunction($handler);

        return array($handler, $instance);
    }

    /**
     * Returns the default value of a specified parameter.
     *
     * @param  \ReflectionParameter $parameter
     * @param  mixed                $value
     * @return mixed
     */
    protected function value(\ReflectionParameter $parameter, $value)
    {
        $available = $parameter->isDefaultValueAvailable();

        if (! $available || $value !== null)
        {
            return $value;
        }

        return $parameter->getDefaultValue();
    }
}
