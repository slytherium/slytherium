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
     * Tests ResponseInterface::getStatusCode.
     *
     * @return void
     */
    public function testGetStatusCodeMethod()
    {
        $expected = 404;

        $response = $this->response->withStatus($expected);

        $result = $response->getStatusCode();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResponseInterface::getReasonPhrase.
     *
     * @return void
     */
    public function testGetReasonPhraseMethod()
    {
        $expected = 'Internal Server Error';

        $response = $this->response->withStatus(500);

        $result = $response->getReasonPhrase();

        $this->assertEquals($expected, $result);
    }
}
