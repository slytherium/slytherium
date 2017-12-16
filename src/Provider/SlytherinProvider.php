<?php

namespace Slytherium\Provider;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Slytherium\Container\WritableInterface;
use Slytherium\Provider\Slytherin\BridgeContainer;
use Slytherium\Provider\Slytherin\Container;

/**
 * Slytherin Provider
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinProvider implements ProviderInterface
{
    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface
     */
    protected $integration;

    /**
     * Initializes the provider instance.
     *
     * @param \Rougin\Slytherin\Integration\IntegrationInterface $integration
     */
    public function __construct(IntegrationInterface $integration)
    {
        $this->integration = $integration;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Slytherium\Container\WritableInterface $container
     * @return \Slytherium\Container\WritableInterface
     */
    public function register(WritableInterface $container)
    {
        $container = new Container($container);

        $integration = $this->integration;

        $config = $container->get(ProviderInterface::CONFIG);

        $config = new Configuration($config->all());

        $result = $integration->define($container, $config);

        return new BridgeContainer($result);
    }
}
