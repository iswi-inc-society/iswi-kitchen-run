<?php

use KitchenRun\Inc\Admin\Team_List_Table;
use League\Plates\Template\Template;

/**
 * View to render the Team List Table.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template            $this    Event Page Object has the needed Event_Table_List object as property.
 * @var     string              $title   Title of the Page
 * @var     Team_List_Table     $table    Link to the new Event Form
 * @var     string              $new     Add New text translation
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?= $title ?></h1>
    <a class="page-title-action" href="<?= $table->get_new_team_link() ?>"><?= $this->e($new) ?></a>

    <div id="kr-list-table-events">
        <div id="kr-post-body">
            <form id="kr-event-list-form" method="get">
                <?= $table->display() ?>
            </form>
        </div>
    </div>
</div>