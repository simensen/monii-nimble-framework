<?php

namespace Monii\Nimble;

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
