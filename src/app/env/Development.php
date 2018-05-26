<?php declare(strict_types=1);

namespace app\env;

error_reporting(-1);
ini_set('display_errors', '1');

class Development implements \lib\Environment
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
