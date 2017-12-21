<?php

namespace Zapheus\Http\Message;

/**
 * Uploaded File Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UploadedFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var \Zapheus\Http\Message\UploadedFileInterface
     */
    protected $uploaded;

    /**
     * Sets up the uploaded file instance.
     *
     * @return void
     */
    public function setUp()
    {
        $file = $this->file = __DIR__ . '/../../Fixture/Views/HelloWorld.php';

        $this->uploaded = $this->instance($file);
    }

    /**
     * Tests UploadedFileInterface::getClientFilename.
     *
     * @return void
     */
    public function testGetClientFilenameMethod()
    {
        $expected = basename($this->file);

        $result = $this->uploaded->getClientFilename();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UploadedFileInterface::getClientMediaType.
     *
     * @return void
     */
    public function testGetClientMediaTypeMethod()
    {
        $expected = mime_content_type($this->file);

        $result = $this->uploaded->getClientMediaType();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UploadedFileInterface::getError.
     *
     * @return void
     */
    public function testGetErrorMethod()
    {
        $expected = UPLOAD_ERR_OK;

        $result = $this->uploaded->getError();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UploadedFileInterface::getSize.
     *
     * @return void
     */
    public function testGetSizeMethod()
    {
        $expected = filesize($this->file);

        $result = $this->uploaded->getSize();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests UploadedFileInterface::getStream.
     *
     * @return void
     */
    public function testGetStreamMethod()
    {
        $expected = 'Zapheus\Http\Message\StreamInterface';

        $result = $this->uploaded->getStream();

        $this->assertInstanceof($expected, $result);
    }

    /**
     * Tests UploadedFileInterface::moveTo.
     *
     * @return void
     */
    public function testMoveToMethod()
    {
        $target = str_replace('HelloWorld', 'MovedFile', $this->file);

        $this->uploaded->moveTo($target);

        $this->assertFileExists($target);

        $uploaded = $this->instance($target);

        $uploaded->moveTo($this->file);
    }

    /**
     * Creates a new \UploadedFileInterface instance.
     *
     * @param  string $file
     * @return \UploadedFileInterface
     */
    protected function instance($file)
    {
        file_put_contents($file, 'Hello world');

        $size = filesize($file);

        $name = basename($file);

        $type = mime_content_type($file);

        return new UploadedFile($file, $size, UPLOAD_ERR_OK, $name, $type);
    }
}
