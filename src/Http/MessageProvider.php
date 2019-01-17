<?php

namespace Zapheus\Http;

use Zapheus\Application;
use Zapheus\Container\WritableInterface;
use Zapheus\Http\Message\RequestFactory;
use Zapheus\Http\Message\Response;
use Zapheus\Provider\ProviderInterface;

/**
 * Message Provider
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class MessageProvider implements ProviderInterface
{
    const REQUEST = Application::REQUEST;

    const RESPONSE = Application::RESPONSE;

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $response = new Response;

        $config = $container->get(self::CONFIG);

        $factory = new RequestFactory;

        $factory->cookies($config->get('app.http.cookies', $_COOKIE));

        $factory->data($config->get('app.http.post', $_POST));

        $factory->files($config->get('app.http.uploaded', $_FILES));

        $factory->queries($config->get('app.http.get', $_GET));

        $factory->server($config->get('app.http.server', $_SERVER));

        $container->set(self::REQUEST, $factory->make());

        return $container->set(self::RESPONSE, $response);
    }
}
