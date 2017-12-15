<?php

namespace Slytherium\Provider\Slytherin;

use Rougin\Slytherin\Container\ContainerInterface;
use Slytherium\Container\WritableInterface;
use Slytherium\Provider\Common\Container as CommonContainer;

/**
 * Slytherin to Slytherium Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BridgeContainer extends CommonContainer implements WritableInterface
{
    /**
     * Initializes the container instance.
     *
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
