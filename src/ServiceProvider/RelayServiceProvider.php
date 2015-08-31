<?php

namespace Monii\Nimble\ServiceProvider;

use Illuminate\Contracts\Container\Container;
use Monii\Http\Middleware\Psr7\ActionHandler\ActionHandler;
use Monii\Http\Middleware\Psr7\NikicFastRoute\NikicFastRoute;
use Monii\Nimble\App;
use Relay\Middleware\ResponseSender;
use Relay\Relay;
use Relay\RelayBuilder;

class RelayServiceProvider
{
    public function register(Container $container)
    {
        $container->bind(Relay::class, function (Container $container) {
            /** @var RelayBuilder $relayBuilder */
            $relayBuilder = $container->make(RelayBuilder::class);

            $queue = array_merge(
                [
                    $container->make(ResponseSender::class),
                    $container->make(NikicFastRoute::class, [
                        'actionAttributeName' => App::DEFAULT_ACTION_ATTRIBUTE_NAME,
                        'parametersAttributeName' => App::DEFAULT_PARAMETERS_ATTRIBUTE_NAME,
                    ]),
                ],
                $container->tagged('middleware.error_handler'),
                $container->tagged('middleware.early'),
                $container->tagged('middleware'),
                $container->tagged('middleware.late'),
                [
                    $container->make(ActionHandler::class, [
                        'actionAttributeName' => App::DEFAULT_ACTION_ATTRIBUTE_NAME,
                    ]),
                ]
            );

            return $relayBuilder->newInstance($queue);
        });
    }
}
