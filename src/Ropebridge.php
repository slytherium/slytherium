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

    const BRIDGE_RESPONSE = 'Zapheus\Bridge\Psr\Interop\Response';

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

        $bases = array('Psr\Http\Message\ResponseInterface');

        $bases[] = 'Psr\Http\Message\ServerRequestInterface';
        $bases[] = 'Zapheus\Http\Message\RequestInterface';
        $bases[] = 'Zapheus\Http\Message\ResponseInterface';

        $bridges = array('Zapheus\Bridge\Psr\Zapheus\Response');

        $bridges[] = 'Zapheus\Bridge\Psr\Zapheus\Request';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\ServerRequest';
        $bridges[] = 'Zapheus\Bridge\Psr\Interop\Response';

        $this->bridges = array_combine($bases, $bridges);
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

        return $exists && $instanceof ? new $bridge($this->object) : $this->object;
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
