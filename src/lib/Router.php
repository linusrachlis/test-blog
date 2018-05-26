<?php declare(strict_types=1);

namespace lib;

trait Router
{
    function route(array $routes, string $request_uri) : void
    {
        $query_string_begin_pos = strpos($request_uri, '?');
        $url = (false === $query_string_begin_pos) ?
            $request_uri :
            substr($request_uri, 0, $query_string_begin_pos);

        foreach ($routes as $pattern => $function)
        {
            if (preg_match("<$pattern>", $url, $matches))
            {
                array_shift($matches);
                call_user_func_array($function, $matches);
                break;
            }
        }
    }
}
