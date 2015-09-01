<?php

namespace Monii\Nimble;

use Illuminate\Contracts\Container\Container;
use Monii\Nimble\ServiceProvider\ActionHandlerServiceProvider;
use Monii\Nimble\ServiceProvider\ContainerServiceProvider;
use Monii\Nimble\ServiceProvider\NikicFastRouteServiceProvider;
use Monii\Nimble\ServiceProvider\RelayServiceProvider;

class App
{
    const DEFAULT_ACTION_ATTRIBUTE_NAME = 'monii/nimble-app:action';
    const DEFAULT_PARAMETERS_ATTRIBUTE_NAME = 'monii/nimble-app:parameters';

    protected function makeAndRegisterServiceProviders(Container $container, array $serviceProviderClassNames)
    {
        foreach ($serviceProviderClassNames as $providerClassName) {
            $provider = $container->make($providerClassName);

            $provider->register($container);
        }
    }

    public function registerServiceProviders(Container $container)
    {
        $this->makeAndRegisterServiceProviders($container, [
            ContainerServiceProvider::class,
            ActionHandlerServiceProvider::class,
            NikicFastRouteServiceProvider::class,
            RelayServiceProvider::class,
        ]);
    }
}
