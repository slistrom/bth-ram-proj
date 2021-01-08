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
<h1><?= $question->title ?></h1>

<?= $question->text ?>

<p><u><strong>Tags</strong></u><p>
<?php foreach ($tags as $tag) : ?>
    <a href="<?= url("forum/showtag/{$tag->text}"); ?>"><?= $tag->text ?></a>
<?php endforeach; ?>

<p><a href="update">Post an answer</a></p>

</article>
