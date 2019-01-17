<?php

namespace Zapheus\Http\Message;

/**
 * Response Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\ResponseFactory
     */
    protected $factory;

    /**
     * Sets up the factory instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->factory = new ResponseFactory(new Response);
    }

    /**
     * Tests ResponseInterface::code.
     *
     * @return void
     */
    public function testCodeMethod()
    {
        $this->factory->code($expected = 404);

        $result = $this->factory->make()->code();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResponseInterface::reason.
     *
     * @return void
     */
    public function testReasonMethod()
    {
        $expected = 'Internal Server Error';

        $this->factory->code(500);

        $result = $this->factory->make()->reason();

        $this->assertEquals($expected, $result);
    }
}
