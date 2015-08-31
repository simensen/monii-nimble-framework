<?php

namespace Monii\Nimble\ServiceProvider;

use Illuminate\Contracts\Container\Container;
use Monii\Http\Middleware\Psr7\ActionHandler\ActionHandlerResolver;
use Monii\Http\Middleware\Psr7\ActionHandler\Resolver\CallableResolver;
use Monii\Http\Middleware\Psr7\ActionHandler\Resolver\ContainerInterop\ObjectFromContainerResolver;
use Monii\Http\Middleware\Psr7\ActionHandler\Resolver\ResolverChain;

class ActionHandlerServiceProvider
{
    public function register(Container $container)
    {
        $container->singleton(ActionHandlerResolver::class, function (Container $container) {
            return new ResolverChain([
                $container->make(CallableResolver::class),
                $container->make(ObjectFromContainerResolver::class),
            ]);
        });
    }
}
