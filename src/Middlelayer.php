<?php

namespace Zapheus;

use Zapheus\Http\Message\RequestInterface;
use Zapheus\Http\MessageProvider;
use Zapheus\Http\Server\ApplicationHandler;
use Zapheus\Http\Server\Dispatcher;

/**
 * Middlelayer
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Middlelayer
{
    /**
     * @var \Zapheus\Http\Server\DispatcherInterface
     */
    protected $original;

    /**
     * @var \Zapheus\Application
     */
    protected $application;

    /**
     * Initializes the application instance.
     *
     * @param \Zapheus\Application|null $application
     */
    public function __construct(Application $application = null)
    {
        $this->application = $application;

        $this->application->add(new MessageProvider);

        $this->original = new Dispatcher;
    }

    /**
     * Dispatches the request and returns it into a response.
     *
     * @param  \Zapheus\Http\Message\RequestInterface $request
     * @return \Zapheus\Http\Message\ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        return $this->original->process($request, $this->application);
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function run()
    {
        $interface = Application::REQUEST;

        $request = $this->application->get($interface);

        $response = $this->handle($request);

        $this->application->emit($response);

        return $response->stream();
    }

    /**
     * Calls methods from the Application instance.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->original, $method) === true) {
            $class = array($this->original, $method);

            return call_user_func_array($class, $parameters);
        }

        if (method_exists($this->application, $method)) {
            $class = array($this->application, $method);

            return call_user_func_array($class, $parameters);
        }

        $message = 'Method "' . $method . '" is undefined!';

        throw new \BadMethodCallException((string) $message);
    }
}
