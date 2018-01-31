<?php

namespace Zapheus\Application;

use Zapheus\Fixture\Http\Controllers\HailController;
use Zapheus\Fixture\Http\Controllers\LaudController;

/**
 * Router Application Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RouterApplicationTest extends AbstractTestCase
{
    /**
     * Sets up the application instance.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = new RouterApplication($this->application());

        $this->define(new HailController);

        $instance = 'Zapheus\Fixture\Http\Controllers\LaudController';

        $this->app->connect('/greet', $instance . '@greet');

        $this->app->delete('/greet', $instance . '@greet');

        $this->app->get('/greet', $instance . '@greet');

        $this->app->head('/greet', $instance . '@greet');

        $this->app->options('/greet', $instance . '@greet');

        $this->app->patch('/greet', $instance . '@greet');

        $this->app->post('/greet', $instance . '@greet');

        $this->app->purge('/greet', $instance . '@greet');

        $this->app->put('/greet', $instance . '@greet');

        $this->app->trace('/greet', $instance . '@greet');
    }

    /**
     * Tests AbstractApplication::run.
     *
     * @return void
     */
    public function testRunMethod()
    {
        $app = $this->request('GET', '/greet');

        $expected = 'Hello, world and people';

        $result = (string) $app->run();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests an unknown method.
     *
     * @return void
     */
    public function testUnknownMethod()
    {
        $this->setExpectedException('BadMethodCallException');

        $this->app->test();
    }
}
