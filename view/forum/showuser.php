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
<h1>User info</h1>

<p><img src="<?= $gravatar ?>" class="gravatar"></p>
<p>Email: <?= $user->acronym ?></p>
<p>Firstname: <?= $user->firstname ?></p>
<p>Lastname: <?= $user->lastname ?></p>

<h4>Questions by user</h4>

<?php foreach ($questions as $question) : ?>
    <a href="<?= url("forum/showquestion/{$question->id}"); ?>"><?= $question->title ?></a><br>
<?php endforeach; ?>

</article>
