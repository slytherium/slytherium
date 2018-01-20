<?php

namespace Zapheus\Http;

use Zapheus\Container\WritableInterface;
use Zapheus\Http\Message\Request;
use Zapheus\Http\Message\Response;
use Zapheus\Provider\ProviderInterface;

/**
 * Message Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MessageProvider implements ProviderInterface
{
    const SERVER_REQUEST = 'Zapheus\Http\Message\RequestInterface';

    const RESPONSE = 'Zapheus\Http\Message\ResponseInterface';

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(self::CONFIG);

        $cookies = $config->get('app.http.cookies', $_COOKIE);

        $data = $config->get('app.http.post', $_POST);

        $files = $config->get('app.http.uploaded', $_FILES);

        $query = $config->get('app.http.get', $_GET);

        $server = $config->get('app.http.server', $_SERVER);

        $request = new Request($server, $cookies, $data, $files, $query);

        $container->set(self::RESPONSE, new Response);

        return $container->set(self::SERVER_REQUEST, $request);
    }
}
