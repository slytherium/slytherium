<?php

namespace Zapheus\Routing;

/**
 * Route
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Route
{
    const ALLOWED_REGEX = '[a-zA-Z0-9\_\-]+';

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var callable|string
     */
    protected $handler;

    /**
     * Initializes the route instance.
     *
     * @param string          $method
     * @param string          $uri
     * @param callable|string $handler
     */
    public function __construct($method, $uri, $handler)
    {
        $this->method = $method;

        $this->uri = $uri[0] !== '/' ? '/' . $uri : $uri;

        $this->handler = $handler;
    }

    /**
     * Returns the HTTP method.
     *
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Returns the URI.
     *
     * @return string
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Returns the handler.
     *
     * @return callable|string
     */
    public function handler()
    {
        return $this->handler;
    }

    /**
     * Returns a regular expression pattern from the given URI.
     *
     * @link https://stackoverflow.com/q/30130913
     *
     * @return string
     */
    public function regex()
    {
        // Turn "(/)" into "/?"
        $uri = preg_replace('#\(/\)#', '/?', (string) $this->uri);

        // Create capture group for ":parameter", replaces ":parameter"
        $uri = $this->capture($uri, '/:(' . self::ALLOWED_REGEX . ')/');

        // Create capture group for '{parameter}', replaces "{parameter}"
        $uri = $this->capture($uri, '/{(' . self::ALLOWED_REGEX . ')}/');

        // Add start and end matching
        return '@^' . $uri . '$@D';
    }

    /**
     * Capture the specified regular expressions.
     *
     * @param  string $pattern
     * @param  string $search
     * @return string
     */
    protected function capture($pattern, $search)
    {
        $replace = '(?<$1>' . self::ALLOWED_REGEX . ')';

        return preg_replace($search, $replace, $pattern);
    }
}
