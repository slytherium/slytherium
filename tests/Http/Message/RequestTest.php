<?php

namespace Zapheus\Http\Message;

/**
 * Request Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * Sets up the request instance.
     *
     * @return void
     */
    public function setUp()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $_SERVER['REQUEST_URI'] = '/';

        $_SERVER['SERVER_NAME'] = 'rougin.github.io';

        $_SERVER['SERVER_PORT'] = 8000;

        $_SERVER['HTTPS'] = 'off';

        $this->request = new Request($_SERVER);
    }

    /**
     * Tests RequestInterface::attributes.
     *
     * @return void
     */
    public function testAttributesMethod()
    {
        $expected = array('name' => 'Rougin Royce');

        $request = $this->request->set('attributes', $expected);

        $result = $request->attributes();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::cookies.
     *
     * @return void
     */
    public function testCookiesMethod()
    {
        $expected = array('name' => 'Rougin', 'address' => 'Tomorrowland');

        $cookies = $this->request->cookies();

        $cookies->set('address', 'Tomorrowland');

        $cookies->set('name', 'Rougin');

        $request = $this->request->set('cookies', $cookies);

        $result = $request->cookies()->all();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::data.
     *
     * @return void
     */
    public function testDataMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $request = $this->request->set('data', $expected);

        $result = $request->data();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::files.
     *
     * @return void
     */
    public function testFilesMethod()
    {
        $file = new File('/test.txt', 0, 0, 'test.txt', 'text/plain');

        $expected = array($file);

        $request = $this->request->set('files', $expected);

        $result = $request->files();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::method.
     *
     * @return void
     */
    public function testMethodMethod()
    {
        $expected = 'POST';

        $request = $this->request->set('method', $expected);

        $result = $request->method();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::query.
     *
     * @return void
     */
    public function testQueryMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $query = $this->request->query();

        $query->set('name', 'Rougin Royce');

        $query->set('age', 20);

        $request = $this->request->set('query', $query);

        $result = $request->query()->all();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::server.
     *
     * @return void
     */
    public function testServerMethod()
    {
        $result = $this->request->server()->all();

        $expected = $_SERVER;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::target.
     *
     * @return void
     */
    public function testTargetMethod()
    {
        $expected = 'origin-form';

        $request = $this->request->set('target', $expected);

        $result = $request->target();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::uri.
     *
     * @return void
     */
    public function testUriMethod()
    {
        $expected = new Uri('https://rougin.github.io');

        $request = $this->request->set('uri', $expected);

        $result = $request->uri();

        $this->assertEquals($expected, $result);
    }
}
