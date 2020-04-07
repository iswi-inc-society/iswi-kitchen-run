<?php
use KitchenRun\Inc\Admin\Event_List_Table;
use KitchenRun\Inc\Admin\Event_New;

/**
 * View to render a form to create/add new events in the wordpress backend using the Event_List_Table and Event_New Classes.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Event_List_Table    $event_table  Event Table Object to render the table.
 * @var       Event_New           $this         Object of the class where this view is included.
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php _e('New Kitchen Run Events', $this->plugin_text_domain); ?></h2>

    <?php foreach ($this->messages as $message): ?>
        <p><?php echo $message; ?></p>
    <?php endforeach; ?>

    <div id="nds-wp-form-kr-new-event">
        <div id="nds-form-body">
            <form id="nds-new-event-form" method="post">

                <?php wp_nonce_field( 'add_event', '_wpnonce_add_event' ); ?>

                <table id="createevent" class="form-table" role="presentation">

                    <tr class="form-field form-required">
                        <th scope="row"><label>Event Name</label></th>
                        <td><input type="text" name="event_name" value="" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Opening Date</label></th>
                        <td><input type="date" name="opening_date" value="" required /><input type="time" name="opening_time" value="" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Closing Date </label></th>
                        <td><input type="date" name="closing_date" value="" required /><input type="time" name="closing_time" value="" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Event Date </label></th>
                        <td><input type="date" name="event_date" value="" required /><input type="time" name="event_time" value="" required /></td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label>Current</label></th>
                        <td><input type="checkbox" name="event_current" /></td>
                    </tr>

                </table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="event_submit" value="Create Event" />
                </p>
            </form>
        </div>
    </div>
</div>