<?php

namespace Anax\View;

/**
 * View to display all questions.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("forum/askquestion");



?><h1>Forum questions</h1>

<p>
    <a href="<?= $urlToCreate ?>">Ask a new question</a>
</p>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>

    <?php
    return;
endif;
?>


<h4>Questions</h4>
<?php foreach ($items as $item) : ?>
    <p><a href="<?= url("forum/showquestion/{$item->id}"); ?>"><?= $item->title ?></a></p>
<?php endforeach; ?>
