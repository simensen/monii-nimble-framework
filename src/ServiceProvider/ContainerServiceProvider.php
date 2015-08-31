<?php

namespace Monii\Nimble\ServiceProvider;

use Illuminate\Contracts\Container\Container;
use Interop\Container\ContainerInterface;
use Monii\Interop\Container\Laravel\LaravelContainer;

class ContainerServiceProvider
{
    public function register(Container $container)
    {
        $container->singleton(Container::class, function () use ($container) {
            return $container;
        });

        $container->singleton(ContainerInterface::class, LaravelContainer::class);
    }
}
