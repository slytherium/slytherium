<?php

namespace Slytherium\Provider;

use Slytherium\Container\Container;
use Slytherium\Fixture\Providers\SlytherinAuthBundle;
use Slytherium\Fixture\Providers\SlytherinRoleBundle;

/**
 * Symfony Provider Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SymfonyProviderTest extends \PHPUnit_Framework_TestCase
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
        $class = 'Slytherium\Provider\ConfigurationInterface';

        $config = new Configuration;

        $root = __DIR__ . '/../Fixture';

        $this->deleteFiles($root . '/Symfony/cache');

        $this->deleteFiles($root . '/Symfony/logs');

        $config->set('symfony.kernel.debug', true);
        $config->set('symfony.kernel.environment', 'dev');
        $config->set('symfony.kernel.project_dir', $root);
        $config->set('symfony.kernel.root_dir', $root . '/Symfony');
        $config->set('symfony.kernel.secret', 'secret');

        $this->container = new Container;

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
        $container = $this->container;

        $role = new SymfonyProvider(new SlytherinRoleBundle);

        $auth = new SymfonyProvider(new SlytherinAuthBundle);

        $container = $role->register($container);

        $container = $auth->register($container);

        $container = $this->framework->register($container);

        $expected = 'Slytherium\Fixture\Http\Controllers\AuthController';

        $result = $container->get('auth');

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Deletes the directory recursively.
     *
     * @param  string $target
     * @return void
     */
    protected function deleteFiles($target)
    {
        if (is_dir($target) === true) {
            // GLOB_MARK adds a slash to directories returned
            $files = glob($target . '*', GLOB_MARK);

            foreach ($files as $file) {
                $this->deleteFiles($file);
            }

            return file_exists($target) && rmdir($target);
        }

        file_exists($target) && unlink($target);
    }
}
