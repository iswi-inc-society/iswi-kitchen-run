<?php

use KitchenRun\Inc\Admin\Event_Page;

/**
 * View to render the Event List Table.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Event_Page   $this  Event Page Object has the needed Event_Table_List object as property.
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Kitchen Run Events', $this->plugin_text_domain); ?></h1>
    <a class="page-title-action" href="<?php echo $this->event_table->get_new_event_link()?>"><?php _e('Add New', $this->plugin_text_domain); ?></a>
    <div id="kr-list-table-events">
        <div id="kr-post-body">
            <form id="kr-event-list-form" method="get">
                <?php $this->event_table->display(); ?>
            </form>
        </div>
    </div>
</div>