<?php declare(strict_types=1);

namespace app;

require_once APP_DIR . '/lib.php';

error_reporting(-1);
ini_set('display_errors', '1');

class DevelopmentEnvironment implements Environment
{
    use \lib\Router;

    function pdo() : \PDO
    {
        static $pdo;

        if (!isset($pdo)) {
            $pdo = new \PDO('mysql:host=db;dbname=blog', 'blog', 'pass');
        }

        return $pdo;
    }
}

return new DevelopmentEnvironment;
