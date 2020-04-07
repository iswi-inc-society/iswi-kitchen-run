<?php
use KitchenRun\Inc\Common\Model\Event;

/**
 * View to render a form to edit existing events in the wordpress backend.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Event     $event  Event Object that will be edited.
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php _e('Update Kitchen Run Event', $this->plugin_text_domain); ?></h2>

    <div id="wp-form-kr-update-event">
        <div id="kr-form-body">
            <form id="nds-new-event-form" method="post">

                <?php wp_nonce_field( 'update_event', '_wpnonce_update_event' ); ?>
                <input type="hidden" name="event_id" value="<?php echo $event->getId() ?>">

                <table id="createevent" class="form-table" role="presentation">

                    <tr class="form-field form-required">
                        <th scope="row"><label>Event Name</label></th>
                        <td><input type="text" name="event_name" value="<?php echo $event->getName() ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Opening Date</label></th>
                        <td><input type="date" name="opening_date" value="<?php echo $event->getOpeningDate()->format('Y-m-d') ?>" required /><input type="time" name="opening_time" value="<?php echo $event->getOpeningDate()->format('H:m') ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Closing Date </label></th>
                        <td><input type="date" name="closing_date" value="<?php echo $event->getClosingDate()->format('Y-m-d') ?>" required /><input type="time" name="closing_time" value="<?php echo $event->getClosingDate()->format('H:m') ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Event Date </label></th>
                        <td><input type="date" name="event_date" value="<?php echo $event->getEventDate()->format('Y-m-d') ?>" required /><input type="time" name="event_time" value="<?php echo $event->getEventDate()->format('H:m') ?>" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Current</label></th>
                        <td><input type="checkbox" name="event_current" <?php if ($event->getCurrent()) echo "checked"; ?>/></td>
                    </tr>

                </table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="event_submit" value="Update Event" />
                </p>


            </form>
        </div>
    </div>
</div>