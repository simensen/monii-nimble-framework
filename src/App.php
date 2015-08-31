<?php

namespace Monii\Nimble;

use Illuminate\Contracts\Container\Container;
use Monii\Nimble\ServiceProvider\ActionHandlerServiceProvider;
use Monii\Nimble\ServiceProvider\ContainerServiceProvider;
use Monii\Nimble\ServiceProvider\NikicFastRouteServiceProvider;
use Monii\Nimble\ServiceProvider\RelayServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;

class App
{
    const DEFAULT_ACTION_ATTRIBUTE_NAME = 'monii/nimble-app:action';
    const DEFAULT_PARAMETERS_ATTRIBUTE_NAME = 'monii/nimble-app:parameters';

    protected $registeredServiceProviderClassNames = [];

    public function __construct(array $serviceProviderClassNames = [])
    {
        $this->addRegisteredServiceProviderClassNames($serviceProviderClassNames);
    }

    protected function registerServiceProviderClassNames()
    {
        $this->addRegisteredServiceProviderClassNames([
            ContainerServiceProvider::class,
            ActionHandlerServiceProvider::class,
            NikicFastRouteServiceProvider::class,
            RelayServiceProvider::class,
        ]);
    }

    protected function addRegisteredServiceProviderClassNames(array $providerClassNames)
    {
        $this->registeredServiceProviderClassNames = array_merge(
            $this->registeredServiceProviderClassNames,
            $providerClassNames
        );
    }

    private function registerServiceProviders(Container $container)
    {
        foreach ($this->registeredServiceProviderClassNames as $providerClassName) {
            $provider = $container->make($providerClassName);

            $provider->register($container);
        }
    }

    public function run(
        Container $container,
        ServerRequestInterface $request = null,
        ResponseInterface $response = null
    ) {
        $this->registerServiceProviderClassNames();
        $this->registerServiceProviders($container);

        /** @var Relay $relay */
        $relay = $container->make(Relay::class);

        return $relay(
            $request ?: $container->make(ServerRequestInterface::class),
            $response ?: $container->make(ResponseInterface::class)
        );
    }
}
