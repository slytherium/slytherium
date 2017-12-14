<?php

namespace Slytherium\Http\Server;

use Slytherium\Fixture\Http\Middlewares\FinalMiddleware;
use Slytherium\Fixture\Http\Middlewares\JsonMiddleware;
use Slytherium\Http\Message\ServerRequest;
use Slytherium\Http\Server\Dispatcher;

/**
 * Dispatcher Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Http\Server\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var \Slytherium\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * Sets up the dispatcher instance.
     *
     * @return void
     */
    public function setUp()
    {
        list($items, $server) = array(array(), array());

        $items[] = new JsonMiddleware;

        $this->dispatcher = new Dispatcher($items);

        $server['REQUEST_METHOD'] = 'GET';
        $server['REQUEST_URI'] = '/';
        $server['SERVER_NAME'] = 'rougin.github.io';
        $server['SERVER_PORT'] = 8000;

        $this->request = new ServerRequest($server);
    }

    /**
     * Tests DispatcherInterface::dispatch.
     *
     * @return void
     */
    public function testDispatchMethod()
    {
        $this->dispatcher->pipe(new FinalMiddleware);

        $expected = array('application/json');

        $response = $this->dispatcher->dispatch($this->request);

        $result = $response->getHeader('Content-Type');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests DispatcherInterface::dispatch with \LogicException.
     *
     * @return void
     */
    public function testDispatchMethodWithLogicException()
    {
        $this->setExpectedException('LogicException');

        $this->dispatcher->dispatch($this->request);
    }
}
