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
        $subject_field = $form->field('subject');
        $body_field = $form->field('body');

        if ('POST' == $_SERVER['REQUEST_METHOD'])
        {
            $form->populate($_POST);
            $subject_field->required();
            $body_field->required();

            if ($form->is_valid())
            {
                $stmt = env()->pdo()->prepare(
                    "INSERT INTO `post` (`posted_at`, `subject`, `body`)
                    VALUES (NOW(), ?, ?)");
                $result = $stmt->execute($form->values(
                    $subject_field,
                    $body_field));
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
                <?php $subject_field->begin() ?>
                <input type=text name="%name" value="%value" %attr>
                <?php $subject_field->end('class=error') ?>
            </label>
            <?= $subject_field->errors('<div class=error>%s</div>') ?>
            <label>
                Body<br>
                <?php $body_field->begin() ?>
                <textarea name="%name" %attr>%value</textarea>
                <?php $body_field->end('class=error') ?>
            </label>
            <?= $body_field->errors('<div class=error>%s</div>') ?>
            <div>
                <button type=submit>Create</button>
            </div>
        </form>
        <?php
        App::output_page(ob_get_clean(), "New Post");
    }
}
