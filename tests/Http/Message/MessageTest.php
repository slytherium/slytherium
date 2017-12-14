<?php

namespace Slytherium\Http\Message;

/**
 * Message Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Http\Message\MessageInterface
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
     * Tests MessageInterface::getBody.
     *
     * @return void
     */
    public function testGetBodyMethod()
    {
        $expected = 'Slytherium\Http\Message\StreamInterface';

        $result = $this->message->getBody();

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Tests MessageInterface::getBody with another stream instance.
     *
     * @return void
     */
    public function testGetBodyMethodWithAnotherStreamInstance()
    {
        $stream = new Stream(fopen('php://temp', 'r+'));

        $stream->write('Hello, world');

        $message = $this->message->withBody($stream);

        $expected = (string) $stream;

        $result = (string) $message->getBody();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::getHeader.
     *
     * @return void
     */
    public function testGetHeaderMethod()
    {
        $message = $this->message->withHeader('name', 'Rougin');

        $expected = array('Rougin');

        $result = $message->getHeader('name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::getHeaderLine.
     *
     * @return void
     */
    public function testGetHeaderLineMethod()
    {
        $names = array('Rougin', 'Royce');

        $message = $this->message->withHeader('names', $names);

        $expected = 'Rougin,Royce';

        $result = $message->getHeaderLine('names');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::getHeaders.
     *
     * @return void
     */
    public function testGetHeadersMethod()
    {
        $names = array('Rougin', 'Royce');

        $message = $this->message->withHeader('names', $names);

        $expected = array('names' => $names);

        $result = $message->getHeaders();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::withAddedHeader.
     *
     * @return void
     */
    public function testWithAddedHeaderMethod()
    {
        $message = $this->message->withHeader('name', 'Rougin');

        $message = $message->withAddedHeader('name', 'Royce');

        $expected = array('Rougin', 'Royce');

        $result = $message->getHeader('name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::getProtocolVersion.
     *
     * @return void
     */
    public function testGetProtocolVersionMethod()
    {
        $expected = '2.0';

        $message = $this->message->withProtocolVersion($expected);

        $result = $message->getProtocolVersion();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::withoutHeader.
     *
     * @return void
     */
    public function testWithoutHeaderMethod()
    {
        $message = $this->message->withHeader('name', 'Rougin');

        $message = $message->withAddedHeader('framework', 'Slytherin');

        $message = $message->withoutHeader('name');

        $this->assertFalse($message->hasHeader('name'));
    }
}
