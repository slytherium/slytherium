<?php

namespace Zapheus;

use Zapheus\Application\ApplicationInterface;
use Zapheus\Container\Container;
use Zapheus\Container\ContainerInterface;
use Zapheus\Container\WritableInterface;
use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\Message\ResponseInterface;

/**
 * Application
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Application implements ApplicationInterface, WritableInterface
{
    const CONFIGURATION = 'Zapheus\Provider\ConfigurationInterface';

    const DISPATCHER = 'Zapheus\Routing\DispatcherInterface';

    const REQUEST = 'Zapheus\Http\Message\RequestInterface';

    const RESOLVER_ATTRIBUTE = 'request-handler';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

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

        if ($container->has(self::CONFIGURATION) === false) {
            $configuration = new Provider\Configuration;

            $container->set(self::CONFIGURATION, $configuration);
        }

        $this->container = $container;
    }

    /**
     * Adds a new provider to be registered.
     *
     * @param  \Zapheus\Provider\ProviderInterface $provider
     * @return self
     */
    public function add($provider)
    {
        $container = $this->container;

        $container = $provider->register($container);

        $this->container = $container;

        $this->providers[] = get_class($provider);

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

        $headers = $response->headers()->all();

        $version = $response->version();

        header(sprintf('HTTP/%s %s', $version, $code));

        foreach ($headers as $name => $values) {
            $value = implode(',', $values);

            header($name . ': ' . $value);
        }

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
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        list($attributes, $result) = array($request->attributes(), null);

        $resolver = $attributes->get(self::RESOLVER_ATTRIBUTE);

        if ($this->container->has(self::DISPATCHER) === true) {
            $dispatcher = $this->container->get(self::DISPATCHER);

            $path = (string) $request->uri()->path();

            $method = (string) $request->method();

            $resolver = $dispatcher->dispatch($method, $path);
        }

        $resolver && $result = $resolver->resolve($this->container);

        return $this->response($result);
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

    /**
     * Converts the given result into a response instance.
     *
     * @param  mixed $result
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    protected function response($result)
    {
        $instanceof = $result instanceof ResponseInterface;

        $response = $this->container->get(self::RESPONSE);

        $instanceof || $response->stream()->write($result);

        return $instanceof ? $result : $response;
    }
}
