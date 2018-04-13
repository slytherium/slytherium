<?php

namespace Zapheus;

/**
 * Ropebridge
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Ropebridge
{
    const BRIDGE_REQUEST = 'Zapheus\Bridge\Psr\Interop\ServerRequest';

    const PSR_REQUEST = 'Psr\Http\Message\ServerRequestInterface';

    const PSR_RESPONSE = 'Psr\Http\Message\ResponseInterface';

    /**
     * @var array
     */
    protected $bridges = array();

    /**
     * @var mixed
     */
    protected $object;

    /**
     * Initializes the ropebridge instance.
     *
     * @param mixed $object
     */
    public function __construct($object)
    {
        $this->object = $object;

        $psrs = array('Psr\Http\Message\ResponseInterface');

        $psrs[] = 'Psr\Http\Message\ServerRequestInterface';
        $psrs[] = 'Zapheus\Http\Message\RequestInterface';
        $psrs[] = 'Zapheus\Http\Message\ResponseInterface';

        $bridges = array('Zapheus\Bridge\Psr\Zapheus\Response');

        $bridges[] = 'Zapheus\Bridge\Psr\Zapheus\Request';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\ServerRequest';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\Response';

        $this->bridges = array_combine($psrs, $bridges);
    }

    /**
     * Converts the specified instance into a bridge and vice versa.
     *
     * @param  string $interface
     * @return mixed
     */
    public function bridge($interface)
    {
        $exists = class_exists($this->bridges[$interface]);

        $bridge = (string) $this->bridges[$interface];

        $instanceof = is_a($this->object, $interface);

        if ($exists && $instanceof === true) {
            $reflection = new \ReflectionClass($bridge);

            $items = (array) array($this->object);

            return $reflection->newInstanceArgs($items);
        }

        return $this->object;
    }

    /**
     * Creates a new Ropebridge instance.
     *
     * @param  mixed  $object
     * @param  string $interface
     * @return mixed
     */
    public static function make($object, $interface)
    {
        $instance = new Ropebridge($object);

        return $instance->bridge($interface);
    }
}
