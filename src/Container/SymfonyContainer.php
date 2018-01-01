<?php

namespace Zapheus\Container;

use Symfony\Component\DependencyInjection\ContainerInterface as Symfony;

/**
 * Symfony to Zapheus Container
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyContainer extends SlytherinContainer
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
    public function __construct(Symfony $container)
    {
        $this->container = $container;
    }
}
