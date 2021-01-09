<?php

namespace Anax\View;

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
<h1>One Place home page</h1>
<p>One Place for all your questions about cars!</p>
<h3>The five most recent questions</h3>
<?php foreach ($questions as $question) : ?>
    <p><a href="<?= url("forum/showquestion/{$question->id}"); ?>"><?= $question->title ?></a></p>
<?php endforeach; ?>

<h3>The three most popular tags</h3>
<?php foreach ($tags as $tag) : ?>
    <p><a href="<?= url("forum/showtag/{$tag->text}"); ?>"><?= $tag->text ?></a></p>
<?php endforeach; ?>

<h3>The three most active users</h3>
<?php foreach ($users as $user) : ?>
    <p><a href="<?= url("forum/showuser/{$user->id}"); ?>"><?= $user->acronym ?></a></p>
<?php endforeach; ?>

</article>
