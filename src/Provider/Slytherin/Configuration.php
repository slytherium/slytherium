<?php

namespace Slytherium\Provider\Slytherin;

use Rougin\Slytherin\Integration\Configuration as Slytherin;
use Slytherium\Provider\Configuration as Slytherium;

/**
 * Slytherium to Slytherin Bridge Configuration
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Configuration extends Slytherin
{
    /**
     * @var \Slytherium\Provider\ConfigurationInterface
     */
    protected $config;

    /**
     * Initializes the configuration instance.
     *
     * @param \Slytherium\Provider\ConfigurationInterface $config
     */
    public function __construct(Slytherium $config)
    {
        $this->config = $config;
    }

    /**
     * Returns the value from the specified key.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->config->get($key, $default);
    }
}
