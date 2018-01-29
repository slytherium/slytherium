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

        $message = $this->message->with('headers', $expected);

        $result = $message->headers();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::headers with only one per header.
     *
     * @return void
     */
    public function testHeadersMethodWithOnePerHeader()
    {
        $expected = array('names' => array('Rougin', 'Royce'), array('test'));

        $message = $this->message->push('headers', $expected['names'], 'names');

        $message = $message->push('headers', array('test'));

        $result = $message->headers();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::stream.
     *
     * @return void
     */
    public function testStreamMethod()
    {
        $expected = 'Zapheus\Http\Message\Stream';

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

        $message = $this->message->with('stream', $stream);

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

        $message = $this->message->with('version', $expected);

        $result = $message->version();

        $this->assertEquals($expected, $result);
    }
}
