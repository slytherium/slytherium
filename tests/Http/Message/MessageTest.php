<?php

namespace Zapheus\Http\Message;

/**
 * Message Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\MessageInterface
     */
    protected $message;

    /**
     * Sets up the message instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->message = new Message;
    }

    /**
     * Tests MessageInterface::headers.
     *
     * @return void
     */
    public function testHeadersMethod()
    {
        $expected = array('names' => array('Rougin', 'Royce'));

        $headers = new Collection($expected);

        $message = $this->message->set('headers', $headers);

        $result = $message->headers()->all();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::stream.
     *
     * @return void
     */
    public function testStreamMethod()
    {
        $expected = 'Zapheus\Http\Message\StreamInterface';

        $result = $this->message->stream();

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Tests MessageInterface::stream with another stream instance.
     *
     * @return void
     */
    public function testStreamMethodWithAnotherStreamInstance()
    {
        $stream = new Stream(fopen('php://temp', 'r+'));

        $stream->write('Hello, world');

        $message = $this->message->set('stream', $stream);

        $expected = (string) $stream;

        $result = (string) $message->stream();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::version.
     *
     * @return void
     */
    public function testVersionMethod()
    {
        $expected = '2.0';

        $message = $this->message->set('version', $expected);

        $result = $message->version();

        $this->assertEquals($expected, $result);
    }
}
