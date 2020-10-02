<?php

use League\Plates\Template\Template;

/**
 * View to render a form to create/add new events in the wordpress backend using the Event_List_Table and Event_New Classes.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       string    $title          Translation of Title
 * @var       array     $messages       Translation of Messages or Notifications
 * @var       string    $wp_nonce       html of wp_nonce fields of action: add_event (NOT ESCAPED)
 * @var       string    $event_name     Translation of Event Name
 * @var       string    $opening_date   Translation of Opening Date
 * @var       string    $closing_date   Translation of Closing Date
 * @var       string    $event_date     Translation of Event Date
 * @var       string    $current        Translation of Current Event
 * @var       string    $submit         Translation of Create Event
 *
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

	<?php $this->insert('html-notices') ?>

    <h2><?= $this->e($title) ?></h2>

    <div id="nds-wp-form-kr-new-event">
        <div id="nds-form-body">
            <form id="nds-new-event-form" method="post">

                <?= $wp_nonce ?>

                <table id="create_event" class="form-table" role="presentation">

                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_event_name"><?= $this->e($event_name) ?></label>
                        </th>
                        <td>
                            <input id="in_event_name" type="text" name="event_name" value="" required />
                        </td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_opening_date"><?php echo $this->e($opening_date) ?></label>
                            <label for="in_opening_time"></label>
                        </th>
                        <td>
                            <input id="in_opening_date" type="date" name="opening_date" value="" required />
                            <input id="in_opening_time" type="time" name="opening_time" value="" required />
                        </td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_closing_date"><?php echo $this->e($closing_date) ?></label>
                            <label for="in_closing_time"></label>
                        </th>
                        <td>
                            <input id="in_closing_date" type="date" name="closing_date" value="" required />
                            <input id="in_closing_time" type="time" name="closing_time" value="" required />
                        </td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_event_date"><?php echo $this->e($event_date) ?></label>
                            <label for="in_event_time"></label>
                        </th>
                        <td>
                            <input id="in_event_date" type="date" name="event_date" value="" required />
                            <input id="in_event_time" type="time" name="event_time" value="" required />
                        </td>
                    </tr>

                    <tr class="form-field form-required">
                        <th scope="row"><label for="in_event_current"><?php echo $this->e($current) ?></label></th>
                        <td><input id="in_event_current" type="checkbox" name="event_current" /></td>
                    </tr>

                </table>
                <p class="submit">
                    <input class="button button-primary" type="submit" name="event_submit" value="<?php echo $this->e($submit) ?>" />
                </p>
            </form>
        </div>
    </div>
</div>