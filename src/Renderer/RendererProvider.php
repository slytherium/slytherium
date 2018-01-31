<?php

namespace Zapheus\Renderer;

use Zapheus\Container\WritableInterface;
use Zapheus\Provider\ProviderInterface;

/**
 * Renderer Provider
 *
 * @package App
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RendererProvider implements ProviderInterface
{
    const RENDERER = 'Zapheus\Renderer\RendererInterface';

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(ProviderInterface::CONFIG);

        $renderer = new Renderer($config->get('app.views', ''));

        return $container->set(self::RENDERER, $renderer);
    }
}
