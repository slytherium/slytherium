<?php

namespace Zapheus\Decorator;

use Zapheus\Container\WritableInterface;
use Zapheus\Routing\Dispatcher;

class RouterDecorator extends Router implements DecoratorInterface
{
    public function handle(WritableInterface $container)
    {
        $interface = 'Zapheus\Routing\DispatcherInterface';

        $dispatcher = new Dispatcher($this);

        return $container->set($interface, $dispatcher);
    }
}
