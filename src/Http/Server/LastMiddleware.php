<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Last Middleware
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class LastMiddleware implements MiddlewareInterface
{
    /**
     * @var \Zapheus\Http\Server\HandlerInterface
     */
    protected $handler;

    /**
     * Initializes the middleware instance.
     *
     * @param \Zapheus\Http\Server\HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Processes an incoming server request and return a response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @param  \Zapheus\Http\Server\HandlerInterface        $handler
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        return $this->handler->handle($request);
    }
}
