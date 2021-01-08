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


?><h1>Forum users</h1>

<?php if (!$items) : ?>
    <p>There are no items to show.</p>

    <?php
    return;
endif;
?>

<table class="usertable">
    <tr>
        <th>Email</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>User info</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td><?= $item->acronym ?></td>
        <td><?= $item->firstname ?></td>
        <td><?= $item->lastname ?></td>
        <td>
            <a href="<?= url("forum/showuser/{$item->id}"); ?>">Link</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
