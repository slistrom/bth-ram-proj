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
<h1><?= $tag ?></h1>
<p>Questions with this tag:</p>
<?php foreach ($questions as $question) : ?>
    <a href="<?= url("forum/showquestion/{$question->id}"); ?>"><?= $question->title ?></a><br>
<?php endforeach; ?>

</article>
