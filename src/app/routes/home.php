<?php declare(strict_types=1);

namespace app\home_routes;

use function lib\h;
use function app\env;
use function app\output_page;
use app\Post;

function home() : void
{
    ob_start();
    ?>
    <h2>Recent Posts</h2>
    <?php
    $query = env()->pdo()
        ->query("SELECT id, posted_at, subject, body FROM `post` ORDER BY `posted_at` DESC");
    $post = new Post;
    $query->setFetchMode(\PDO::FETCH_INTO, $post);

    while ($query->fetch())
    {
        ?>
        <article>
            <h3>
                <a href="/post/<?= $post->id ?>"><?= h($post->subject) ?></a>
            </h3>
            <p class=timestamp><?= h($post->posted_at) ?></p>
            <?= nl2br(h($post->body)) ?>
        </article>
        <?php
    }

    $content = ob_get_clean();
    output_page($content);
}
