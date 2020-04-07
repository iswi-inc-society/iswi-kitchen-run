<?php

use KitchenRun\Inc\Common\Model\Event;

/**
 * View to render a form to confirm that the user wants to delete an event.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var     Event   $event  Event Object that will be deleted.
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Kitchen Run Events', $this->plugin_text_domain); ?></h1>

    <p><?php _e('You have specified this event for deletion: ', $this->plugin_text_domain); ?></p>



    <form id="delete_event" name="delete_event" method="post">
        <?php wp_nonce_field( 'delete_event_confirmation', '_wpnonce_delete_event' ); ?>


        <input type="hidden" name="event" value="<?php echo $event->getId(); ?>">
        <p>ID#<?php echo $event->getId()?>: <?php echo $event->getName(); ?></p>

        <input type="hidden" name="delete_option" value="delete">
        <input type="hidden" name="action" value="dodelete">

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Confirm Deletion"></p>
    </form>
</div>