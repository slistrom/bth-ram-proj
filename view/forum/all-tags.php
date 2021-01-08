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
// $urlToCreate = url("forum/question");
// $urlToDelete = url("forum/delete");

?><h1>Forum tags</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>

    <?php
    return;
endif;
?>

<?php foreach ($items as $item) : ?>
    <a href="<?= url("forum/showtag/{$item->text}"); ?>"><?= $item->text ?></a>
<?php endforeach; ?>

