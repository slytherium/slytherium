<?php

namespace Zapheus\Provider;

use Rougin\Slytherin\Http\HttpIntegration;
use Zapheus\Bridge\Slytherin\Provider;
use Zapheus\Container\Container;

/**
 * Framework Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class FrameworkProviderTest extends \PHPUnit_Framework_TestCase
{
    const RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        list($config, $container) = array(new Configuration, new Container);

        $this->container = $container->set(ProviderInterface::CONFIG, $config);

        $this->provider = new FrameworkProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $provider = new Provider(array(new HttpIntegration));

        $container = $provider->register($this->container);

        $container = $this->provider->register($container);

        $expected = self::RESPONSE;

        $result = $container->get(self::RESPONSE);

        $this->assertInstanceOf($expected, $result);
    }
}
