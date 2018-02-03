<?php

namespace Zapheus\Decorator;

use Zapheus\Container\WritableInterface;

interface DecoratorInterface
{
    public function handle(WritableInterface $container);
}
