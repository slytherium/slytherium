<?php

namespace Slytherium\Provider;

/**
 * Configuration Test
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Slytherium\Provider\ConfigurationInterface
     */
    protected $config;

    /**
     * Sets up the config instance.
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
     * Tests ConfigurationInterface::load.
     *
     * @return void
     */
    public function testLoadMethod()
    {
        $expected = 'Slytherium Framework';

        $path = str_replace('Provider', 'Fixture', __DIR__) . '/Config/App.php';

        $this->config->load($path);

        $result = $this->config->get('app.app_name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $expected = 'Slytherium';

        $this->config->set('user.name', $expected);

        $result = $this->config->get('user.name');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ConfigurationInterface::offsetExists.
     *
     * @return void
     */
    public function testOffsetExistsMethod()
    {
        $exists = isset($this->config['user.name']);

        $this->assertTrue($exists);
    }

    /**
     * Tests ConfigurationInterface::offsetUnset.
     *
     * @return void
     */
    public function testOffsetUnsetMethod()
    {
        unset($this->config['user.name']);

        $exists = isset($this->config['user.name']);

        $this->assertFalse($exists);
    }
}
