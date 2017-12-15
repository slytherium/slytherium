<?php

namespace Slytherium\Provider\Slytherin;

use Rougin\Slytherin\Container\ContainerInterface;
use Slytherium\Container\WritableInterface;
use Slytherium\Provider\Common\Container as CommonContainer;

/**
 * Slytherium to Slytherin Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container extends CommonContainer implements ContainerInterface
{
    /**
     * Initializes the container instance.
     *
     * @param \Slytherium\Container\WritableInterface $container
     */
    public function __construct(WritableInterface $container)
    {
        $this->container = $container;
    }
}
