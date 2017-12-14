<?php

namespace Slytherium\Renderer;

use Slytherium\Renderer\Renderer;

/**
 * Renderer Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Renderer\RendererInterface
     */
    protected $renderer;

    /**
     * Sets up the renderer instance.
     *
     * @return void
     */
    public function setUp()
    {
        $path = __DIR__ . '/../Fixture/Views';

        $this->renderer = new Renderer($path);
    }

    /**
     * Tests RendererInterface::render.
     *
     * @return void
     */
    public function testRenderMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $result = $this->renderer->render('LoremIpsum');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests RendererInterface::render with \InvalidArgumentException.
     *
     * @return void
     */
    public function testRenderMethodWithInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->renderer->render('InvalidFile');
    }
}
