<?php

use KitchenRun\Inc\Common\Model\Event;
use League\Plates\Template\Template;

/**
 * View to render a form to confirm that the user wants to delete a team.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Event     $event              Team Object that will be edited.
 * @var       Template  $this               Event Page Object has the needed Event_Table_List object as property.
 * @var       string    $title              Title of the Page
 * @var       string    $plugin_text_domain Language Domain
 * @var       string    $submit             Translation of Confirm Deletion
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?= $this->e($title) ?></h1>

    <p><?php _e('You have specified this event to unpair its teams: ', $plugin_text_domain); ?></p>



    <form id="unpair_event" name="unpair_event" method="post">
        <?php wp_nonce_field( 'unpair_event_confirmation', '_wpnonce_unpair_event' ); ?>


        <input type="hidden" name="event" value="<?php echo $event->getId(); ?>">
        <p>ID#<?php echo $event->getId()?>: <?php echo $event->getName(); ?></p>

        <input type="hidden" name="pair_option" value="pair">
        <input type="hidden" name="action" value="pair">

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?= $submit ?>"></p>
    </form>
</div>