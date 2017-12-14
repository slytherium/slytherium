<?php

namespace Slytherium\Container;

/**
 * Reflection Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ReflectionContainer implements ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Slytherium\Container\NotFoundException
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            $message = 'Class (%s) does not exists';

            throw new NotFoundException(sprintf($message, $id));
        }

        $reflection = new \ReflectionClass($id);

        if ($constructor = $reflection->getConstructor()) {
            $arguments = $this->arguments($constructor);

            return $reflection->newInstanceArgs($arguments);
        }

        return new $id;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return class_exists($id);
    }

    /**
     * Returns an argument based on the given parameter.
     *
     * @param  \ReflectionParameter $parameter
     * @param  string               $name
     * @return mixed|null
     */
    protected function argument(\ReflectionParameter $parameter, $name)
    {
        $argument = null;

        try {
            $argument = $parameter->getDefaultValue();
        } catch (\ReflectionException $exception) {
            $argument = $argument ?: $this->get($name);
        }

        return $argument;
    }

    /**
     * Resolves the specified parameters from a container.
     *
     * @param  \ReflectionFunctionAbstract $reflection
     * @return array
     */
    protected function arguments(\ReflectionFunctionAbstract $reflection)
    {
        $arguments = array();

        foreach ($reflection->getParameters() as $key => $parameter) {
            $class = $parameter->getClass();

            $name = $class ? $class->getName() : $parameter->getName();

            $arguments[$key] = $this->argument($parameter, $name);
        }

        return $arguments;
    }
}
