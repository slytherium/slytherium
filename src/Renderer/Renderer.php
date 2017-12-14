<?php

namespace Slytherium\Renderer;

/**
 * Renderer
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Renderer implements RendererInterface
{
    /**
     * @var array
     */
    protected $paths = array();

    /**
     * @param array|string $paths
     */
    public function __construct($paths)
    {
        $this->paths = (array) $paths;
    }

    /**
     * Renders a template.
     *
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function render($template, array $data = array())
    {
        $file = $this->find(str_replace('.', '/', $template) . '.php');

        // Extracts the specific parameters to the template.
        extract($data);

        ob_start();
        
        include $file;

        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }

    /**
     * Finds the specified template from the list of paths.
     *
     * @param  string $template
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function find($template)
    {
        $file = null;

        foreach ((array) $this->paths as $path) {
            $files = glob($path . '/' . $template);

            empty($files) || $file = $files[0];
        }

        if (is_null($file) === true) {
            $message = 'Template (%s) file not found.';

            $message = sprintf($message, $template);

            throw new \InvalidArgumentException($message);
        }

        return $file;
    }
}
