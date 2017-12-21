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
        $file = __DIR__ . '/../../Fixture/Views/LoremIpsum.php';

        $resource = fopen($file, 'r');

        $this->stream = new Stream($resource);
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

    /**
     * Tests StreamInterface::eof.
     *
     * @return void
     */
    public function testEofMethod()
    {
        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $expected = false;

        $result = $stream->eof();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::getContents with \RuntimeException.
     *
     * @return void
     */
    public function testGetContentsMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $stream->getContents();
    }

    /**
     * Tests StreamInterface::getSize.
     *
     * @return void
     */
    public function testGetSizeMethod()
    {
        $expected = 26;

        $result = $this->stream->getSize();

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
     * Tests StreamInterface::read with \RuntimeException.
     *
     * @return void
     */
    public function testReadMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $stream->read(4);
    }

    /**
     * Tests StreamInterface::seek and StreamInterface::tell.
     *
     * @return void
     */
    public function testSeekMethodAndTellMethod()
    {
        $expected = 2;

        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $stream->seek($expected);

        $result = $stream->tell();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests StreamInterface::seek and StreamInterface::detach.
     *
     * @return void
     */
    public function testSeekMethodAndDetachMethod()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $stream->detach();

        $stream->seek(2);
    }

    /**
     * Tests StreamInterface::tell and StreamInterface::detach.
     *
     * @return void
     */
    public function testTellMethodAndDetachMethod()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $resource = fopen($file, 'w');

        $stream = new Stream($resource);

        $stream->detach();

        $stream->tell();
    }

    /**
     * Tests StreamInterface::write with \RuntimeException.
     *
     * @return void
     */
    public function testWriteMethodWithRuntimeException()
    {
        $this->setExpectedException('RuntimeException');

        $file = __DIR__ . '/../../Fixture/Views/LoremIpsum.php';

        $resource = fopen($file, 'r');

        $stream = new Stream($resource);

        $stream->write('Hello world');
    }
}
