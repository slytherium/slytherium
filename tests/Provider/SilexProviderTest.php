<?php

namespace Zapheus\Provider;

use Zapheus\Container\Container;
use Zapheus\Fixture\Providers\BlogServiceProvider;
use Zapheus\Fixture\Providers\UserServiceProvider;

/**
 * Silex Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SilexProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\FrameworkProvider
     */
    protected $framework;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $message = 'Pimple Container is not yet installed.';

        $container = 'Pimple\Container';

        class_exists($container) || $this->markTestSkipped($message);

        $this->container = new Container;

        $class = 'Zapheus\Provider\ConfigurationInterface';

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

        $expected = 'Zapheus\Fixture\Http\Controllers\BlogController';

        $result = $container->get('blog');

        $this->assertInstanceOf($expected, $result);
    }
}
