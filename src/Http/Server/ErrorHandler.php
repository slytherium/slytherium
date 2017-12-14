<?php

namespace Slytherium\Http\Server;

use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Error Handler
 *
 * @package Slytherium
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
    protected $response = 'Slytherium\Http\Message\ResponseInterface';

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
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $message = sprintf($this->message, $this->response);

        throw new \LogicException($message);
    }
}
