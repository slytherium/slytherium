<?php

namespace Zapheus;

use Zapheus\Application\ApplicationInterface;
use Zapheus\Container\Container;
use Zapheus\Container\ContainerInterface;
use Zapheus\Http\Message\Response;
use Zapheus\Http\Message\ResponseInterface;
use Zapheus\Http\Message\ServerRequestInterface;

/**
 * Application
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Application extends Container implements ApplicationInterface
{
    const DISPATCHER = 'Zapheus\Routing\DispatcherInterface';

    const REQUEST = 'Zapheus\Http\Message\ServerRequestInterface';

    const RESOLVER_ATTRIBUTE = 'request-handler';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Container\ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
    }

    /**
     * Emits the headers from the response instance.
     *
     * @param  \Zapheus\Http\Message\ResponseInterface $response
     * @return \Zapheus\Http\Message\ResponseInterface
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
     * @param  \Zapheus\Http\Message\ServerRequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
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
     * @return \Zapheus\Http\Message\ResponseInterface
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
