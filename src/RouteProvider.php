<?php

namespace Monii\Nimble;

use FastRoute;

interface RouteProvider
{
    public function addRoutes(FastRoute\RouteCollector $routeCollector);
}
