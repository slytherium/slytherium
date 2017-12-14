<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;

/**
 * Application Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractApplication implements ApplicationInterface
{
    /**
     * @var \Slytherium\Application
     */
    protected $application;

    /**
     * Initializes the application instance.
     *
     * @param \Slytherium\Application|null $application
     */
    public function __construct(Application $application = null)
    {
        $this->application = $application ?: new Application;
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Rougin\Slytherin\Http\Message\StreamInterface
     */
    public function run()
    {
        $constant = Application::REQUEST;

        $request = $this->application->get($constant);

        $response = $this->handle($request);

        $this->application->emit($response);

        return $response->getBody();
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
        if (method_exists($this->application, $method)) {
            $class = array($this->application, $method);
            
            return call_user_func_array($class, $parameters);
        }

        $message = 'Method "' . $method . '" is undefined!';

        throw new \BadMethodCallException($message);
    }
}
