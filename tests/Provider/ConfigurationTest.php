<?php

namespace Zapheus\Provider;

/**
 * Configuration Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zapheus\Provider\ConfigurationInterface
     */
    protected $config;

    /**
     * Sets up the configuration instance.
     *
     * @return void
     */
    public function setUp()
    {
        $data = array('user' => array());

        $data['user']['name'] = 'Rougin';

        $this->config = new Configuration($data);
    }

    /**
     * Tests ConfigurationInterface::all.
     *
     * @return void
     */
    public function testAllMethod()
    {
        $expected = array('user' => array('name' => 'Rougin'));

        $result = $this->config->all();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::all with "dotify" enabled.
     *
     * @return void
     */
    public function testAllMethodWithDotifyEnabled()
    {
        $expected = array('user.name' => 'Rougin');

        $result = $this->config->all(true);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::get.
     *
     * @return void
     */
    public function testGetMethod()
    {
        $expected = 'Rougin';

        $result = $this->config->get('user.name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::get with an empty array.
     *
     * @return void
     */
    public function testGetMethodWithEmptyArray()
    {
        $expected = array();

        $this->config->set('app.views', array());

        $result = $this->config->get('app.views');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::load.
     *
     * @return void
     */
    public function testLoadMethod()
    {
        $expected = 'Zapheus Framework';

        $path = str_replace('Provider', 'Fixture', __DIR__) . '/Config';

        $this->config->load($path);

        $result = $this->config->get('app.app_name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::load with recursive access.
     *
     * @return void
     */
    public function testLoadMethodWithRecursiveAccess()
    {
        $expected = 'An independent and framework-friendly framework.';

        $path = str_replace('Provider', 'Fixture', __DIR__) . '/Config';

        $this->config->load($path);

        $result = $this->config->get('test.settings.description');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $expected = 'Zapheus';

        $this->config->set('user.name', $expected);

        $result = $this->config->get('user.name');

        $this->assertEquals($expected, $result);
    }
}
