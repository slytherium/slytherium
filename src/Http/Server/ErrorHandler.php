<?php

namespace Zapheus\Http\Server;

use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Error Handler
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ErrorHandler implements HandlerInterface
{
    /**
     * @var string
     */
    protected $default = 'Last middleware did not return a "%s" instance';

    /**
     * @var string
     */
    protected $response = 'Zapheus\Http\Message\ResponseInterface';

    /**
     * @var string
     */
    protected $message;

    /**
     * Initializes the handler instance.
     *
     * @param string|null $message
     */
    public function __construct($message = null)
    {
        $this->message = $message ?: $this->default;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $message = sprintf($this->message, $this->response);

        throw new \LogicException($message);
    }
}
