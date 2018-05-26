<?php declare(strict_types=1);

namespace lib;

interface BaseEnvironment
{
    /**
     * @param array<string, callable> $routes
     */
    function route(array $routes, string $request_uri): void;
}
