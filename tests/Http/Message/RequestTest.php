<?php

namespace Slytherium\Http\Message;

/**
 * Request Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Http\Message\RequestInterface
     */
    protected $request;

    /**
     * Sets up the request instance.
     *
     * @return void
     */
    public function setUp()
    {
        $this->request = new Request;
    }

    /**
     * Tests RequestInterface::getRequestTarget.
     *
     * @return void
     */
    public function testGetRequestTargetMethod()
    {
        $expected = 'origin-form';

        $request = $this->request->withRequestTarget($expected);

        $result = $request->getRequestTarget();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RequestInterface::getMethod.
     *
     * @return void
     */
    public function testGetMethodMethod()
    {
        $expected = 'POST';

        $request = $this->request->withMethod($expected);

        $result = $request->getMethod();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests MessageInterface::getUri.
     *
     * @return void
     */
    public function testGetUriMethod()
    {
        $expected = new Uri('https://rougin.github.io');

        $request = $this->request->withUri($expected);

        $result = $request->getUri();

        $this->assertEquals($expected, $result);
    }
}
