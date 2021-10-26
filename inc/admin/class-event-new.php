<?php


namespace KitchenRun\Inc\Admin;

use DateTime;
use Exception;
use KitchenRun\Inc\Common\Model\Event;
use League\Plates\Engine;

/**
 * Class Team_Page
 * Processes all requests from the Add Event submenu to create a new Event.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Event_New extends Admin
{

    /**
     * Initialization Method that is called after the page is chosen.
     * Called by add_plugin_admin_menu() in Class Admin.
     *
     * @since 1.0.0
     */
    public function init() {

        // form is submitted
        if(isset($_POST['event_submit']) && $this->verify_nonce('add_event')) {

            // process form data
            $opening_date = $_POST['opening_date'].' '.$_POST['opening_time'].':00';
            $closing_date = $_POST['closing_date'].' '.$_POST['closing_time'].':00';
            $event_date = $_POST['event_date'].' '.$_POST['event_time'].':00';

            try { // testing date format and create date objects
                $opening_date = new DateTime($opening_date);
                $closing_date = new DateTime($closing_date);
                $event_date = new DateTime($event_date);
            } catch (Exception $e) {
                Admin_Notice::create('error', __('Datetime has false Format', $this->plugin_text_domain));
            }

            // is opening date before closing date?
            if (($opening_date->getTimestamp() < $closing_date->getTimestamp()) && ($closing_date->getTimestamp() <= $event_date->getTimestamp())) {

                $event = new Event();
                $event->setEventDate($event_date);
                $event->setOpeningDate($opening_date);
                $event->setClosingDate($closing_date);


                if (isset($_POST['event_current'])) { // set current
                    $event->setCurrent(1);

                    //delete old current
                    $old_current = Event::findCurrent();
                    if (isset($old_current)) {
                        $old_current->setCurrent(0);
                        $old_current->save();
                    }

                } else {
                    $event->setCurrent(0);
                }

                $event->setManager(get_userdata(get_current_user_id())); //set current user as manager

                $event->setName($_POST['event_name']);

                $event->setPaired(0);

                $event->save();

				Admin_Notice::create('success', sprintf(esc_html__( 'Successfully created the Event %s', $this->plugin_text_domain ), $event->getName()));

                echo $this->templates->render('referer/html-event-referer'); // js referer
                die(); // so it doesn't automatically load the notices

            } else { // opening date after closing date
                Admin_Notice::create('error',  __( 'Please enter an Opening Date that takes place before the Closing Date. The Event Date has to take place after the Closing Date!', $this->plugin_text_domain ));
            }

        }

        // create wp_nonce field
        ob_start();
        wp_nonce_field( 'add_event', '_wpnonce' );
        $wp_nonce = ob_get_clean();

        echo $this->templates->render('html-new-event-form', [ // render views/html-new-event-form.php
            'title'         => __('New Kitchen Run Events', $this->plugin_text_domain),
            'wp_nonce'      => $wp_nonce,
            'event_name'    => __('Event Name', $this->plugin_text_domain),
            'opening_date'  => __('Opening Date', $this->plugin_text_domain),
            'closing_date'  => __('Closing Date', $this->plugin_text_domain),
            'event_date'    => __('Event Date', $this->plugin_text_domain),
            'current'       => __('Current Event', $this->plugin_text_domain),
            'submit'        => __('Create Event', $this->plugin_text_domain),
        ]);

    }
}