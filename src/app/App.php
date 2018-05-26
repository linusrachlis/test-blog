<?php declare(strict_types=1);

namespace app;

use lib\Lib;
use lib\Environment;

function env() : Environment { return Lib::env(); }
function h(string $unsafe_string) : string { return Lib::html_escape($unsafe_string); }

class App
{
    static function bootstrap() : void
    {
        $routes = [
            '^/$'               => [routes\Home::class, 'index'],
            '^/post/create$'    => [routes\Posts::class, 'create'],
            '^/post/(\d+)$'     => [routes\Posts::class, 'view'],
            '^(.*)$'            => [__CLASS__, 'not_found'],
        ];

        env()->route($routes, $_SERVER['REQUEST_URI']);
    }

    static function output_page(string $content, string $title = null) : void
    {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="/styles/main.css">
            <title>
                <?php
                if (isset($title))
                {
                    echo h($title) . " | ";
                }
                ?>
                Excuse me while I blog
            </title>
        </head>
        <body>
            <header>
                <h1>Excuse me while I blog</h1>
            </header>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/post/create">New Post</a></li>
                </ul>
            </nav>
            <main>
                <?= $content ?>
            </main>
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
    }

    static function not_found(string $url) : void
    {
        header('HTTP/1.1 404 Not found');
        $content = "<p>Page not found: $url";
        self::output_page($content);
    }
}
