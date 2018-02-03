<?php

namespace Zapheus\Http\Message;

/**
 * Stream Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class StreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var \Zapheus\Http\Message\StreamInterface
     */
    protected $stream;

    /**
     * Sets up the stream instance.
     *
     * @return void
     */
    public function setUp()
    {
        $search = 'Http' . DIRECTORY_SEPARATOR . 'Message';

        $root = str_replace($search, 'Fixture', __DIR__);

        $file = (string) $root . '/Views/LoremIpsum.php';

        $this->resource = $resource = fopen($file, 'r');

        $this->stream = new Stream($this->resource);
    }

    /**
     * Tests StreamInterface::__construct.
     *
     * @return void
     */
    public function testConstructMethodWithInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->stream = new Stream;
    }

    public function testResourceMethod()
    {
        $expected = $this->resource;

        $result = $this->stream->resource();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::read.
     *
     * @return void
     */
    public function testReadMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $result = $this->stream->read(26);

        $this->stream->close();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::__toString.
     *
     * @return void
     */
    public function testToStringMagicMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $result = (string) $this->stream;

        $this->stream->close();

        $this->assertEquals($expected, $result);
    }
}
