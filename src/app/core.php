<?php declare(strict_types=1);

namespace app;

use function lib\h;

require_once APP_DIR . '/lib.php';

class Post
{
    /** @var int */     var $id;
    /** @var string */  var $posted_at;
    /** @var string */  var $subject;
    /** @var string */  var $body;

    // static function create_from(array $record) : self
    // {
    //     $post = new self;
    //     assign_to($post, $record);
    //     return $post;
    // }
}

function output_page(string $content, string $title = null) : void
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

function not_found(string $url) : void
{
    header('HTTP/1.1 404 Not found');
    $content = "<p>Page not found: $url";
    output_page($content);
}
