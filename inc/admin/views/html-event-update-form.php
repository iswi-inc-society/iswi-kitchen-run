<?php
use KitchenRun\Inc\Common\Model\Event;
use League\Plates\Template\Template;

/**
 * View to render a form to edit existing events in the wordpress backend.
 *
 * @since     1.0.0
 *
 * @author    Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       string    $title          Translation of Title
 * @var       Event     $event          Event Object that will be edited.
 * @var       string    $date_format    Date Format to covert DateTime 'Y-m-d'
 * @var       string    $hour_format    Date Format to covert DateTime 'H:m'
 * @var       string    $event_name     Translation of Event Name
 * @var       string    $opening_date   Translation of Opening Date
 * @var       string    $closing_date   Translation of Closing Date
 * @var       string    $event_date     Translation of Event Date
 * @var       string    $current        Translation of Current Event
 * @var       string    $submit         Translation of Update Event
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

	<?php $this->insert('html-notices') ?>

    <h2><?= $this->e($title) ?></h2>

    <div id="wp-form-kr-update-event">
        <div id="kr-form-body">
            <form id="nds-new-event-form" method="post">

                <?php wp_nonce_field( 'update_event', '_wpnonce_update_event' ); ?>
                <input type="hidden" name="event_id" value="<?= $this->e($event->getId()) ?>">

                <table id="update_event" class="form-table" role="presentation">

                    <!-- Choose Event Name -->
                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_event_name"><?= $this->e($event_name) ?></label>
                        </th>
                        <td>
                            <input id="in_event_name" type="text" name="event_name" value="<?= $this->e($event->getName()) ?>" required />
                        </td>
                    </tr>

                    <!-- Choose Opening Date -->
                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_opening_date"><?= $this->e($opening_date) ?></label>
                            <label for="in_opening_time"></label>
                        </th>
                        <td>
                            <input id="in_opening_date" type="date" name="opening_date" value="<?= $this->e($event->getOpeningDate()->format($date_format)) ?>" required />
                            <input id="in_opening_time" type="time" name="opening_time" value="<?= $this->e($event->getOpeningDate()->format($hour_format)) ?>" required />
                        </td>
                    </tr>

                    <!-- Choose Closing Date -->
                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_closing_date"><?= $this->e($closing_date) ?></label>
                            <label for="in_closing_time"></label>
                        </th>
                        <td>
                            <input id="in_closing_date" type="date" name="closing_date" value="<?= $this->e($event->getClosingDate()->format($date_format)) ?>" required />
                            <input id="in_closing_time" type="time" name="closing_time" value="<?= $this->e($event->getClosingDate()->format($hour_format)) ?>" required />
                        </td>
                    </tr>

                    <!-- Choose Event Date -->
                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_event_date"><?= $this->e($event_date) ?></label>
                            <label for="in_event_time"></label>
                        </th>
                        <td>
                            <input id="in_event_date" type="date" name="event_date" value="<?= $this->e($event->getEventDate()->format($date_format)) ?>" required />
                            <input id="in_event_time" type="time" name="event_time" value="<?= $this->e($event->getEventDate()->format($hour_format)) ?>" required />
                        </td>
                    </tr>

                    <!-- Is current Event? -->
                    <tr class="form-field form-required">
                        <th scope="row">
                            <label for="in_event_current"><?= $this->e($current) ?></label>
                        </th>
                        <td>
                            <input id="in_event_current" type="checkbox" name="event_current" <?php if ($event->getCurrent()) echo "checked"; ?>/>
                        </td>
                    </tr>
                </table>

                <!-- form submit -->
                <p class="submit">
                    <input class="button button-primary" type="submit" name="event_submit" value="<?= $this->e($submit) ?>" />
                </p>
            </form>
        </div>
    </div>
</div>