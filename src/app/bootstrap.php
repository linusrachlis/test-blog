<?php declare(strict_types=1);

namespace app;

define('ENV_DIR', APP_DIR . '/environments');
define('ROUTE_DIR', APP_DIR . '/routes');

require_once APP_DIR . '/lib.php';

interface Environment extends \lib\BaseEnvironment
{
    function pdo(): \PDO;
}

function env() : Environment
{
    static $env;

    if (!isset($env)) {
        $env_file = ENV_DIR . '/' . APP_ENV . '.php';
        $env = require $env_file;
        if (!($env instanceof Environment))
        {
            exit("Failed to bootstrap");
            // TODO logging
        }
    }

    return $env;
}

require_once APP_DIR . '/logic.php';

$home_route = function (string $remaining_url = '')
{
    require_once ROUTE_DIR . '/home.php';
    $routes = [
        '^$' => 'app\\home_routes\\home',
    ];
    env()->route($routes, $remaining_url);
};

$post_route = function (string $remaining_url)
{
    require_once ROUTE_DIR . '/posts.php';
    $routes = [
        '^create$' => 'app\\post_routes\\create',
        '^(\d+)$' => 'app\\post_routes\\view',
    ];
    env()->route($routes, $remaining_url);
};

$routes = [
    '^/$' => $home_route,
    '^/post/(.*)$' => $post_route,
    '^(.*)$' => 'app\\not_found',
];

env()->route($routes, $_SERVER['REQUEST_URI']);
