<?php

namespace Anax\View;

use Lii\Model\Forum\Qcomment;
use Lii\Model\Forum\Acomment;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?><article <?= classList($classes) ?>>
<h1><?= $question->title ?></h1>

<?= $text ?>

<strong>Tags</strong><br>
<?php foreach ($tags as $tag) : ?>
    <a href="<?= url("forum/showtag/{$tag->text}"); ?>"><?= $tag->text ?></a><br>
<?php endforeach; ?>
<p><strong>Comments</strong></p>
<?php foreach ($qcomments as $comment) : ?>
    <?php $qcommenttext = new Qcomment() ?>
    <?php $qcommenttext->text = $comment->text ?>
    <?= $qcommenttext->getDataFiltered("markdown") ?>
<?php endforeach; ?>

<p><a href="<?= url("forum/answer/{$question->id}"); ?>">Post an answer</a> |
<a href="<?= url("forum/commentq/{$question->id}"); ?>">Comment question</a></p>

<h2>Answers</h2>
<?php foreach ($answerArray as $answer) : ?>
    <?= $answer->getDataFiltered("markdown") ?>
    <a href="<?= url("forum/commenta/{$answer->id}"); ?>">Comment answer</a></p>
    <strong>Comments</strong>
    <?php foreach ($acomments as $comment) : ?>
        <?php if ($comment->answId == $answer->id) : ?>
            <?php $acommenttext = new Acomment() ?>
            <?php $acommenttext->text = $comment->text ?>
            <?= $acommenttext->getDataFiltered("markdown") ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <hr>
<?php endforeach; ?>

</article>
