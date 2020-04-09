<?php

use KitchenRun\Inc\Common\Model\Event;
use League\Plates\Template\Template;

/**
 * View to render a form to confirm that the user wants to delete an event.
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       string    $title          Translation of Title
 * @var       Event     $event          Event Object that will be edited.
 * @var       string    $confirm_delete Translation of Message before deletion
 * @var       string    $submit         Translation of Confirm Deletion
 */


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1 class="wp-heading-inline"><?= $this->e($title) ?></h1>

    <p><?= $this->e($confirm_delete) ?></p>



    <form id="delete_event" name="delete_event" method="post">
        <?php wp_nonce_field( 'delete_event_confirmation', '_wpnonce_delete_event' ); ?>


        <input type="hidden" name="event" value="<?= $this->e($event->getId()) ?>">
        <p>ID#<?= $this->e($event->getId()) ?>: <?= $this->e($event->getName()); ?></p>

        <input type="hidden" name="delete_option" value="delete">
        <input type="hidden" name="action" value="dodelete">

        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?= $this->e($submit) ?>"></p>
    </form>
</div>