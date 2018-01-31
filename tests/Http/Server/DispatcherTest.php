<?php

namespace Zapheus\Http\Server;

use Zapheus\Fixture\Http\Middlewares\LastMiddleware;
use Zapheus\Fixture\Http\Middlewares\JsonMiddleware;
use Zapheus\Http\Message\Request;
use Zapheus\Http\Message\Stream;
use Zapheus\Http\Server\Dispatcher;

/**
 * Dispatcher Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Server\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var \Zapheus\Http\Message\RequestInterface
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

        $this->request = new Request($server);
    }

    /**
     * Tests DispatcherInterface::dispatch.
     *
     * @return void
     */
    public function testDispatchMethod()
    {
        $this->dispatcher->pipe(new LastMiddleware);

        $expected = array('application/json');

        $response = $this->dispatcher->dispatch($this->request);

        $result = $response->header('Content-Type');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests DispatcherInterface::dispatch with closures.
     *
     * @return void
     */
    public function testDispatchMethodWithClosures()
    {
        $this->dispatcher->pipe(function ($request, $next) {
            $response = $next($request);

            $stream = new Stream(fopen('php://temp', 'r+'));

            $text = (string) $response->stream();

            $stream->write($text . ' world');

            return $response->set('stream', $stream);
        });

        $this->dispatcher->pipe(function ($request, $next) {
            $response = $next($request);

            $response->stream()->write('Hello');

            return $response;
        });

        $this->dispatcher->pipe(new LastMiddleware);

        $expected = 'Hello world';

        $response = $this->dispatcher->dispatch($this->request);

        $result = (string) $response->stream();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests DispatcherInterface::dispatch with string.
     *
     * @return void
     */
    public function testDispatchMethodWithString()
    {
        $this->dispatcher->pipe('Zapheus\Fixture\Http\Middlewares\LastMiddleware');

        $expected = array('application/json');

        $response = $this->dispatcher->dispatch($this->request);

        $result = $response->header('Content-Type');

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
