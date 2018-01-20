<?php

namespace Zapheus\Http\Message;

/**
 * Response Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Sets up the response instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->response = new Response;
    }

    /**
     * Tests ResponseInterface::code.
     *
     * @return void
     */
    public function testCodeMethod()
    {
        $expected = 404;

        $response = $this->response->set('code', $expected);

        $result = $response->code();

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

        $response = $this->response->set('code', 500);

        $result = $response->reason();

        $this->assertEquals($expected, $result);
    }
}
