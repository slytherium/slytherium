<?php

namespace Slytherium\Http\Message;

/**
 * Server Request Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ServerRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $files = array('file' => array());

    /**
     * @var \Slytherium\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $server = array();

    /**
     * Sets up the request instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->server['REQUEST_METHOD'] = 'GET';
        $this->server['REQUEST_URI'] = '/';
        $this->server['SERVER_NAME'] = 'rougin.github.io';
        $this->server['SERVER_PORT'] = 8000;

        $this->files['file']['error'] = array(0);
        $this->files['file']['name'] = array('test.txt');
        $this->files['file']['size'] = array(100);
        $this->files['file']['tmp_name'] = array('/tmp/test.txt');
        $this->files['file']['type'] = array('text/plain');

        $this->request = new ServerRequest($this->server, array(), array(), $this->files);
    }

    /**
     * Tests ServerRequestInterface::getAttribute.
     *
     * @return void
     */
    public function testGetAttributeMethod()
    {
        $expected = 'Rougin Royce';

        $request = $this->request->withAttribute('name', $expected);

        $result = $request->getAttribute('name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getAttributes.
     *
     * @return void
     */
    public function testGetAttributesMethod()
    {
        $expected = array('name' => 'Rougin Royce');

        $request = $this->request->withAttribute('name', 'Rougin Royce');

        $result = $request->getAttributes();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getCookieParams.
     *
     * @return void
     */
    public function testGetCookieParamsMethod()
    {
        $expected = array('name' => 'Rougin', 'address' => 'Tomorrowland');

        $request = $this->request->withCookieParams($expected);

        $result = $request->getCookieParams();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getParsedBody.
     *
     * @return void
     */
    public function testGetParsedBodyMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $request = $this->request->withParsedBody($expected);

        $result = $request->getParsedBody();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getQueryParams.
     *
     * @return void
     */
    public function testGetQueryParamsMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $request = $this->request->withQueryParams($expected);

        $result = $request->getQueryParams();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getStatusCode.
     *
     * @return void
     */
    public function testGetStatusCodeMethod()
    {
        $expected = $this->server;

        $result = $this->request->getServerParams();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getUploadedFiles.
     *
     * @return void
     */
    public function testGetUploadedFilesMethod()
    {
        $file = new UploadedFile('/test.txt', 0, 0, 'test.txt', 'text/plain');

        $expected = array($file);

        $request = $this->request->withUploadedFiles($expected);

        $result = $request->getUploadedFiles();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::getUploadedFiles with a single uploaded file.
     *
     * @return void
     */
    public function testGetUploadedFilesMethodWithSingleUploadedFile()
    {
        $files = array('file' => array());

        $files['file']['error'] = 0;
        $files['file']['name'] = 'test.txt';
        $files['file']['size'] = 617369;
        $files['file']['tmp_name'] = '/tmp/test.txt';
        $files['file']['type'] = 'text/plain';

        $request = new ServerRequest($this->server, array(), array(), $files);

        $error = $files['file']['error'];
        $name = $files['file']['name'];
        $size = $files['file']['size'];
        $file = $files['file']['tmp_name'];
        $type = $files['file']['type'];

        $uploaded = new UploadedFile($file, $size, $error, $name, $type);

        $expected = array('file' => array($uploaded));

        $result = $request->getUploadedFiles();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ServerRequestInterface::withoutAttribute.
     *
     * @return void
     */
    public function testWithoutAttributeMethod()
    {
        $request = $this->request->withoutAttribute('REQUEST_METHOD');

        $this->assertNull($request->getAttribute('REQUEST_METHOD'));
    }
}
