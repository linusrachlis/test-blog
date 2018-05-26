<?php declare(strict_types=1);

namespace app\routes;

use app\App;
use app\Post;
use function app\env as env;
use function app\h as h;

class Posts
{
    static function view(int $post_id) : void
    {
        $stmt = env()->pdo()
            ->prepare("SELECT id, posted_at, subject, body FROM `post` WHERE id = ?");
        $stmt->execute([$post_id]);
        $post = new Post;
        $stmt->setFetchMode(\PDO::FETCH_INTO, $post);

        ob_start();

        if ($stmt->fetch())
        {
            $title = $post->subject;
            ?>
            <article>
                <h2><?= h($post->subject) ?></h2>
                <p class=timestamp><?= h($post->posted_at) ?></p>
                <?= nl2br(h($post->body)) ?>
            </article>
            <?php
        }
        else
        {
            header('HTTP/1.1 404 Not found');
            $title = "Post not found";
            ?>
            <p>Post not found.
            <?php
        }
        App::output_page(ob_get_clean(), $title);
    }

    static function create() : void
    {
        $form = new \lib\Form;

        if ('POST' == $_SERVER['REQUEST_METHOD'])
        {
            $form->populate(
                $_POST,
                [
                    'subject',
                    'body'
                ]
            );
            $form->required('subject', 'body');

            if ($form->is_valid())
            {
                $stmt = env()->pdo()->prepare(
                    "INSERT INTO `post` (`posted_at`, `subject`, `body`)
                    VALUES (NOW(), ?, ?)");
                $result = $stmt->execute([$_POST['subject'], $_POST['body']]);
                if (!$result)
                {
                    // TODO logging
                }

                header("Location: /");
            }
        }

        ob_start();
        ?>
        <form method=post>
            <label>
                Subject<br>
                <?php $form->begin_field() ?>
                <input type=text name="%name" value="%value" %attr>
                <?php $form->end_field('subject', 'class=error') ?>
            </label>
            <?= $form->errors('subject', '<div class=error>%s</div>') ?>
            <label>
                Body<br>
                <?php $form->begin_field() ?>
                <textarea name="%name" %attr>%value</textarea>
                <?php $form->end_field('body', 'class=error') ?>
            </label>
            <?= $form->errors('body', '<div class=error>%s</div>') ?>
            <div>
                <button type=submit>Create</button>
            </div>
        </form>
        <?php
        App::output_page(ob_get_clean(), "New Post");
    }
}
