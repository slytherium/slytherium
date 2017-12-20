<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Fixture\Providers\BlogServiceProvider;
use Slytherium\Fixture\Providers\UserServiceProvider;

/**
 * Silex Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SilexProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Slytherium\Provider\FrameworkProvider
     */
    protected $framework;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new Container;

        $class = 'Slytherium\Provider\ConfigurationInterface';

        $config = new Configuration;

        $config->set('silex.user.paths', array());

        $this->container->set($class, $config);

        $this->framework = new FrameworkProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $user = new SilexProvider(new UserServiceProvider);

        $blog = new SilexProvider(new BlogServiceProvider);

        $container = $user->register($this->container);

        $container = $blog->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\BlogController';

        $result = $container->get('blog');

        $this->assertInstanceOf($expected, $result);
    }
}
