<?php

namespace Zapheus\Application;

use Zapheus\Application;
use Zapheus\Http\MessageProvider;

/**
 * Application Interface
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractApplication implements ApplicationInterface
{
    /**
     * @var object
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
        $this->application = $application ?: new Application;

        $this->application->add(new MessageProvider);
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Zapheus\Http\Message\StreamInterface
     */
    public function run()
    {
        $request = $this->application->get(Application::REQUEST);

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
        } elseif (method_exists($this->application, $method)) {
            $class = array($this->application, $method);
            
            return call_user_func_array($class, $parameters);
        }

        $message = 'Method "' . $method . '" is undefined!';

        throw new \BadMethodCallException($message);
    }
}
