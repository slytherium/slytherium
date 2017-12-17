<?php

namespace Slytherium\Provider\Symfony;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Slytherium\Provider\Slytherin\Container as SlytherinContainer;

/**
 * Symfony to Slytherium Bridge Container
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Container extends SlytherinContainer
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Initializes the container instance.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
