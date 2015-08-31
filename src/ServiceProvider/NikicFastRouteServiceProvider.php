<?php

namespace Monii\Nimble\ServiceProvider;

use FastRoute;
use Illuminate\Contracts\Container\Container;
use Monii\Http\Middleware\Psr7\NikicFastRoute\Parameters\ParametersReader;
use Monii\Nimble\App;
use Monii\Nimble\RouteProvider;

class NikicFastRouteServiceProvider
{
    public function register(Container $container)
    {
        $container->bind(FastRoute\Dispatcher::class, function (Container $container) {
            $routeCollector = $container->make(FastRoute\RouteCollector::class);

            return new FastRoute\Dispatcher\GroupCountBased($routeCollector->getData());
        });

        $container->bind(FastRoute\RouteParser::class, FastRoute\RouteParser\Std::class);
        $container->bind(FastRoute\DataGenerator::class, FastRoute\DataGenerator\GroupCountBased::class);

        $container->afterResolving(FastRoute\RouteCollector::class, function (FastRoute\RouteCollector $routeCollector, Container $container) {
            /** @var RouteProvider $routeProvider */
            foreach ($container->tagged('route_provider') as $routeProvider) {
                $routeProvider->addRoutes($routeCollector);
            }
        });

        $container->bind(ParametersReader::class, function () {
            return new ParametersReader(App::DEFAULT_PARAMETERS_ATTRIBUTE_NAME);
        });
    }
}
