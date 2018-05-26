<?php declare(strict_types=1);

namespace lib;

class Lib
{
    static function env() : Environment
    {
        static $env;

        if (!isset($env)) {
            $env_class = '\\app\\env\\' . ucfirst(APP_ENV);
            $env = new $env_class;
            if (!($env instanceof Environment))
            {
                exit("Failed to bootstrap");
                // TODO logging
            }
        }

        return $env;
    }

    static function html_escape(string $unsafe_string) : string
    {
        return htmlspecialchars($unsafe_string);
    }

    // static function assign_to(object $object, array $array) : void
    // {
    //     foreach ($array as $key => $value)
    //     {
    //         $object->$key = $value;
    //     }
    // }
}
