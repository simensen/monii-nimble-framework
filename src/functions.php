<?php

namespace Monii\Nimble;
use Illuminate\Contracts\Container\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;

/**
 * Create an action string for routing.
 *
 * Allows one to more easily create a route naming including its
 * fully-qualified class name. This is mostly sugar to allow
 * the use of `::class` when naming methods on a class to
 * call to execute an action.
 *
 * @param string $className
 * @param string $methodName
 * @return string
 */
function action($className, $methodName)
{
    return implode('@', [$className, $methodName]);
}

/**
 * Create a Relay instance and handle an HTTP request.
 *
 * @param Container $container
 * @param ServerRequestInterface|null $request
 * @param ResponseInterface|null $response
 * @return ResponseInterface
 */
function relay(
    Container $container,
    ServerRequestInterface $request = null,
    ResponseInterface $response = null
) {
    $this->registerServiceProviders($container);

    /** @var Relay $relay */
    $relay = $container->make(Relay::class);

    return $relay(
        $request ?: $container->make(ServerRequestInterface::class),
        $response ?: $container->make(ResponseInterface::class)
    );
}
