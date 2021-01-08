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
<h1>Your information</h1>

<p><img src="<?= $gravatar ?>" class="gravatar"></p>
<p>E-mail: <?= $user->acronym ?></p>
<p>First name: <?= $user->firstname ?></p>
<p>Last name: <?= $user->lastname ?></p>
<p><a href="update">Edit information</a></p>

</article>
