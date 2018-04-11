<?php

namespace Zapheus;

use Zapheus\Container\Container;
use Zapheus\Container\WritableInterface;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Message\ResponseInterface;
use Zapheus\Http\Server\HandlerInterface;
use Zapheus\Http\Server\RoutingHandler;
use Zapheus\Provider\ProviderInterface;

/**
 * Application
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Application implements HandlerInterface, WritableInterface
{
    const MIDDLEWARE = 'Zapheus\Http\Server\DispatcherInterface';

    const REQUEST = 'Zapheus\Http\Message\RequestInterface';

    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var string[]
     */
    protected $providers = array();

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Container\WritableInterface|null $container
     */
    public function __construct(WritableInterface $container = null)
    {
        $container = $container === null ? new Container : $container;

        if ($container->has(ProviderInterface::CONFIG) === false) {
            $configuration = new Provider\Configuration;

            $container->set(ProviderInterface::CONFIG, $configuration);
        }

        $this->container = $container;
    }

    /**
     * Adds a new provider to be registered.
     *
     * @param  \Zapheus\Provider\ProviderInterface $provider
     * @return self
     */
    public function add(ProviderInterface $provider)
    {
        $container = $this->container;

        $this->container = $provider->register($container);

        $this->providers[] = (string) get_class($provider);

        return $this;
    }

    /**
     * Emits the headers from the response instance.
     *
     * @param  \Zapheus\Http\Message\ResponseInterface $response
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function emit(ResponseInterface $response)
    {
        $code = $response->code() . ' ' . $response->reason();

        $headers = $response->headers();

        $version = (string) $response->version();

        foreach ($headers as $name => $values) {
            $value = implode(',', $values);

            header($name . ': ' . $value);
        }

        header(sprintf('HTTP/%s %s', $version, $code));

        return $response;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string $id
     * @return mixed
     *
     * @throws \Zapheus\Container\NotFoundException
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

   /**
     * Dispatches the request and returns into a response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $handler = new RoutingHandler($this->container);

        if ($this->has(self::MIDDLEWARE) === true) {
            $dispatcher = $this->get(self::MIDDLEWARE);

            return $dispatcher->process($request, $handler);
        }

        return $handler->handle($request);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param  string $id
     * @return boolean
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Returns an array of registered providers.
     *
     * @return string[]
     */
    public function providers()
    {
        return $this->providers;
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function run()
    {
        $request = $this->container->get(self::REQUEST);

        $response = $this->handle($request);

        return $this->emit($response)->stream();
    }

    /**
     * Sets a new instance to the container.
     *
     * @param  string $id
     * @param  mixed  $concrete
     * @return self
     *
     * @throws \Zapheus\Container\ContainerException
     */
    public function set($id, $concrete)
    {
        $this->container->set($id, $concrete);

        return $this;
    }
}
