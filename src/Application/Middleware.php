<?php

namespace Slytherium\Application;

use Slytherium\Application;
use Slytherium\Http\Message\ServerRequestInterface;
use Slytherium\Http\Server\ApplicationHandler;
use Slytherium\Http\Server\Dispatcher;

/**
 * Middleware Application
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Middleware extends Dispatcher implements ApplicationInterface
{
    /**
     * @var \Application
     */
    protected $application;

    /**
     * Initializes the decorator instance.
     *
     * @param \Application|null $application
     */
    public function __construct(Application $application = null)
    {
        $this->application = $application ?: new Application;
    }

    /**
     * Handles the ServerRequest to convert it to a Response.
     *
     * @param  \Slytherium\Http\Message\ServerRequestInterface $request
     * @return \Slytherium\Http\Message\ResponseInterface
     */
    public function handle(ServerRequestInterface $request)
    {
        $handler = new ApplicationHandler($this->application);

        return $this->process($request, $handler);
    }

    /**
     * Runs the application and returns the stream instance.
     *
     * @return \Rougin\Slytherin\Http\Message\StreamInterface
     */
    public function run()
    {
        $request = $this->application->get(Application::REQUEST);

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
     */
    public function __call($method, $parameters)
    {
        $result = $this;

        if (method_exists($this->application, $method)) {
            $class = array($this->application, $method);
            
            $result = call_user_func_array($class, $parameters);
        }

        return $result;
    }
}
