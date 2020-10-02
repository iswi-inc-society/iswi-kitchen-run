<?php

use League\Plates\Template\Template;

/**
 * View to render the Event List Table. Using Templating Engine Plates.
 *
 * Renderer Executed in event_list_table_page() in Event_Page class.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Template   $this    Event Page Object has the needed Event_Table_List object as property.
 * @var     string     $title   Title of the Page
 * @var     string     $link    Link to the new Event Form
 * @var     string     $new     Add New text translation
 * @var     string     $table   Table in generated HTML; Not escaped.
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

	<?php $this->insert('html-notices') ?>

    <h1 class="wp-heading-inline"> <?php echo $this->e($title) ?> </h1>
    <a class="page-title-action" href="<?php echo $this->e($link)?>"><?php echo $this->e($new) ?></a>
    <div id="kr-list-table-events">
        <div id="kr-post-body">
            <form id="kr-event-list-form" method="get">
                <?php echo $table; ?>
            </form>
        </div>
    </div>
</div>