<?php

namespace Slytherium\Renderer;

/**
 * Renderer Interface
 *
 * @package Slytherium
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface RendererInterface
{
    /**
     * Renders a template.
     *
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function render($template, array $data = array());
}
