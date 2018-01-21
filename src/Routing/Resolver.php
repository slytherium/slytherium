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
     * @var object|mixed
     */
    protected $handler;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * Initializes the resolver instance.
     *
     * @param object|mixed $handler
     * @param array        $parameters
     */
    public function __construct($handler, $parameters)
    {
        $this->handler = $handler;

        $this->parameters = $parameters;
    }

    /**
     * Resolves the specified handler against a container instance.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @return mixed
     */
    public function resolve(ContainerInterface $container)
    {
        $this->container = $container;

        if (is_string($this->handler) === true) {
            list($class, $method) = explode('@', $this->handler);

            $reflection = new \ReflectionMethod($class, $method);

            $instance = $this->instance($class);

            $this->handler = array($instance, $method);

            return $this->execute($reflection);
        }

        $reflection = new \ReflectionFunction($this->handler);

        return $this->execute($reflection);
    }

    /**
     * Returns the dispatched result.
     *
     * @return array
     */
    public function result()
    {
        return array($this->handler, $this->parameters);
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
     * Executes the specified handler with its required reflection.
     *
     * @param  \ReflectionFunctionAbstract $reflection
     * @return mixed
     */
    protected function execute(\ReflectionFunctionAbstract $reflection)
    {
        $parameters = $this->arguments($reflection, $this->parameters);

        return call_user_func_array($this->handler, $parameters);
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

        if ($constructor = $reflection->getConstructor()) {
            $arguments = $this->arguments($constructor);

            return $reflection->newInstanceArgs($arguments);
        }

        return $this->container->get($class);
    }
}
