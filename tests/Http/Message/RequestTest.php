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

        $_FILES['file']['error'] = array(0);

        $file = __DIR__ . '/../../Fixture/Views/LoremIpsum.php';

        $_FILES['file']['name'] = array(basename($file));

        $_FILES['file']['tmp_name'] = array($file);

        $this->request = new Request($_SERVER, array(), array(), $_FILES);
    }

    /**
     * Tests RequestInterface::attribute.
     *
     * @return void
     */
    public function testAttributeMethod()
    {
        $expected = array('name' => 'Rougin Royce');

        $request = $this->request->with('attributes', $expected);

        $result = $request->attribute('name');

        $this->assertEquals($expected['name'], $result);
    }

    /**
     * Tests RequestInterface::attributes.
     *
     * @return void
     */
    public function testAttributesMethod()
    {
        $expected = array('name' => 'Rougin Royce');

        $request = $this->request->with('attributes', $expected);

        $result = $request->attributes();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::cookie.
     *
     * @return void
     */
    public function testCookieMethod()
    {
        $expected = 'Tomorrowland';

        $cookies = array('name' => 'Rougin', 'address' => 'Tomorrowland');

        $request = $this->request->with('cookies', $cookies);

        $result = $request->cookie('address');

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

        $request = $this->request->with('cookies', $expected);

        $result = $request->cookies();

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

        $request = $this->request->with('data', $expected);

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
        $fixtures = __DIR__ . '/../../Fixture';

        $file = new File($fixtures . '/Views/LoremIpsum.php', 'LoremIpsum.php');

        $expected = array($file);

        $request = $this->request->with('files', $expected);

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

        $request = $this->request->with('method', $expected);

        $result = $request->method();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::queries.
     *
     * @return void
     */
    public function testQueriesMethod()
    {
        $expected = array('name' => 'Rougin Royce', 'age' => 20);

        $request = $this->request->with('queries', $expected);

        $result = $request->queries();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::query.
     *
     * @return void
     */
    public function testQueryMethod()
    {
        $expected = 'Rougin Royce';

        $queries = array('name' => 'Rougin Royce', 'age' => 20);

        $request = $this->request->with('queries', $queries);

        $result = $request->query('name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::server.
     *
     * @return void
     */
    public function testServerMethod()
    {
        $result = $this->request->server();

        $expected = $_SERVER;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::server with a specified name.
     *
     * @return void
     */
    public function testServerMethodWithSpecifiedName()
    {
        $expected = (string) 'rougin.github.io';

        $result = $this->request->server('SERVER_NAME');

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

        $request = $this->request->with('target', $expected);

        $result = $request->target();

        $this->assertEquals($expected, $result);
    }
}
