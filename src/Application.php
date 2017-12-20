<?php

namespace Slytherium;

use Slytherium\Application\ApplicationInterface;
use Slytherium\Container\Container;
use Slytherium\Http\Message\Response;
use Slytherium\Http\Message\ResponseInterface;
use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Application
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Application extends Container implements ApplicationInterface
{
    const DISPATCHER = 'Slytherium\Routing\DispatcherInterface';

    const REQUEST = 'Slytherium\Http\Message\ServerRequestInterface';

    const RESOLVER_ATTRIBUTE = 'request-handler';

    const RESPONSE = 'Slytherium\Http\Message\ResponseInterface';

    /**
     * Initializes the application instance.
     *
     * @param \Slytherium\Container\ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
    }

    /**
     * Emits the headers from the response instance.
     *
     * @param  \Slytherium\Http\Message\ResponseInterface $response
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function emit(ResponseInterface $response)
    {
        $code = $response->getStatusCode();

        $code .= ' ' . $response->getReasonPhrase();

        $headers = $response->getHeaders();

        $version = $response->getProtocolVersion();

        header(sprintf('HTTP/%s %s', $version, $code));

        foreach ($headers as $name => $values) {
            $value = implode(',', $values);

            header($name . ': ' . $value);
        }

        return $response;
    }

    /**
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $resolver = $request->getAttribute(self::RESOLVER_ATTRIBUTE);

        if ($this->has(self::DISPATCHER) === true) {
            $dispatcher = $this->get(self::DISPATCHER);

            $path = $request->getUri()->getPath();

            $method = $request->getMethod();

            $resolver = $dispatcher->dispatch($method, $path);
        }

        $result = $resolver ? $resolver->resolve($this) : null;

        return $this->response($result);
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Rougin\Slytherin\Http\Message\StreamInterface
     */
    public function run()
    {
        $request = $this->get(self::REQUEST);

        $response = $this->handle($request);

        return $this->emit($response)->getBody();
    }

    /**
     * Converts the given result into a response instance.
     *
     * @param  mixed $result
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    protected function response($result)
    {
        $instanceof = $result instanceof ResponseInterface;

        $response = new Response;

        $this->has(self::RESPONSE) && $response = $this->get(self::RESPONSE);

        $instanceof || $response->getBody()->write($result);

        return $instanceof ? $result : $response;
    }
}
