<?php


namespace KitchenRun\Inc\Admin;


use DateTime;
use Exception;
use KitchenRun\Inc\Common\Model\Event;
use League\Plates\Engine;

/**
 * Class Event_Page
 * Processes all requests from the Events submenu and Events page.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Event_Page
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    private $plugin_text_domain;

    /**
     * Event List Object to create the list of events
     *
     * @since   1.0.0
     * @access  private
     * @var     Event_List_Table    $event_table
     */
    private $event_table;

    /**
     * Templating Engine Plates
     *
     * @since   1.0.0
     * @access  private
     * @var     Engine  $templates
     */
    private $templates;


    /**
     * Initialize the class and set its properties.
     *
     * @since       1.0.0
     * @param       string $plugin_name        The name of this plugin.
     * @param       string $version            The version of this plugin.
     * @param       string $plugin_text_domain The text domain of this plugin.
     */
    public function __construct( $plugin_name, $version, $plugin_text_domain ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;

        $this->templates = new Engine(__DIR__ . '/views');

    }

    /**
     * Initialization Method that is called after the page is chosen.
     * Called by add_plugin_admin_menu() in Class Admin.
     *
     * @since 1.0.0
     */
    public function init() {

        if(isset($_GET['action'])) { // do several actions

            if ($_GET['action'] == 'delete') { // delete event
                $this->event_delete_page();

            } else if ($_GET['action'] == 'edit') { // edit event
                $this->event_update_page();
            }

        } else { // render event list table
            $this->event_list_table_page();
        }
    }


    /**
     * Screen options for the List Table
     *
     * Callback for the load-($page_hook_suffix)
     * Called when the plugin page is loaded
     *
     * @since 1.0.0
     */
    public function load_event_list_table_screen_options() {
        $arguments = array(
            'label'		=>	__( 'Events Per Page', $this->plugin_text_domain ),
            'default'	=>	5,
            'option'	=>	'events_per_page'
        );
        add_screen_option( 'per_page', $arguments );

        //init for event list table
        $this->event_table = new Event_List_Table( $this->plugin_name, $this->version ,$this->plugin_text_domain );
    }


    /**
     * Renders the Event List Table.
     * Uses the WP_LIST_TABLE Class from Wordpress to create it.
     *
     * @since 1.0.0
     */
    private function event_list_table_page(){
        // query, filter, and sort the data
        $this->event_table->prepare_items();

        ob_start(); // create variable with html of table

        $this->event_table->display();

        $table = ob_get_clean();

        // Render a template
        echo $this->templates->render('html-event-list', [
            'title' => __('Kitchen Run Events', $this->plugin_text_domain),
            'link'  => $this->event_table->get_new_event_link(),
            'new'   => __('Add New', $this->plugin_text_domain),
            'table' => $table,
        ]);
    }

    /**
     * Renders the Event edit form and processes it.
     *
     * @since 1.0.0
     */
    private function event_update_page()
    {
        // form is submitted
        if(isset($_POST['event_submit'])) {
            if ( // check wpnonce -> to verify the validity of the form
                !isset($_POST['_wpnonce_update_event'])
                || !wp_verify_nonce($_POST['_wpnonce_update_event'], 'update_event')
            ) {

	            Admin_Notice::create('error', __('The WPnonce didn\'t verify please try again!', $this->plugin_text_domain));

            } else { // wpnonce successfully checked

                $event = Event::findbyId($_POST['event_id']);

                // process form data
                if (isset($_POST['opening_date']) && isset($_POST['opening_time'])) {
                    $opening_date = $_POST['opening_date'] . ' ' . $_POST['opening_time'] . ':00';
                } else { $opening_date = 0; }

                if (isset($_POST['closing_date']) && isset($_POST['closing_time'])) {
                    $closing_date = $_POST['closing_date'] . ' ' . $_POST['closing_time'] . ':00';
                } else { $closing_date = 0; }
                if (isset($_POST['event_date']) && isset($_POST['event_time'])) {
                    $event_date = $_POST['event_date'] . ' ' . $_POST['event_time'] . ':00';
                } else { $event_date = 0; }

                try { // testing date format and create date objects
                    $opening_date = new DateTime($opening_date);
                    $closing_date = new DateTime($closing_date);
                    $event_date = new DateTime($event_date);
                } catch (Exception $e) {
	                Admin_Notice::create('error', __('Datetime has false Format', $this->plugin_text_domain));
                }

                // is opening date before closing date?
                if (($opening_date->getTimestamp() < $closing_date->getTimestamp()) && ($closing_date->getTimestamp() <= $event_date->getTimestamp())) {
                    $event->setEventDate($event_date);
                    $event->setOpeningDate($opening_date);
                    $event->setClosingDate($closing_date);

                    if (isset($_POST['event_current'])) { // set current
                        if(!$event->getCurrent()) {
                            $event->setCurrent(1);

                            //delete old current
                            $old_current = Event::findCurrent();

                            if (isset($old_current)) {
                                $old_current->setCurrent(0);
                                $old_current->save();
                            }
                        }
                    } else {
                        $event->setCurrent(0);
                    }

                    $event->setName($_POST['event_name']);

                    $event->save();

	                Admin_Notice::create('success', sprintf(esc_html__( 'Successfully updated the Event %s', $this->plugin_text_domain ), $event->getName()));
                    echo $this->templates->render('html-event-referer'); // render views/html-event-referer.php
	                die();

                }
            }
        }

        $event = Event::findbyId($_GET['event']);
        echo $this->templates->render('html-event-update-form',[ // render views/html-event-update-form.php
            'title'         => __('Update Kitchen Run Event', $this->plugin_text_domain),
            'event'         => $event,
            'date_format'   => 'Y-m-d',
            'hour_format'   => 'H:m',
            'event_name'    => __('Event Name', $this->plugin_text_domain),
            'opening_date'  => __('Opening Date', $this->plugin_text_domain),
            'closing_date'  => __('Closing Date', $this->plugin_text_domain),
            'event_date'    => __('Event Date', $this->plugin_text_domain),
            'current'       => __('Current Event', $this->plugin_text_domain),
            'submit'        => __('Update Event', $this->plugin_text_domain),
        ]);
    }

    /**
     * Renders the Page to confirm the event deletion process or submits this process and deletes the event
     *
     * @since 1.0.0
     */
    private function event_delete_page() {
        if (
            ! isset( $_GET['_wpnonce'] )
            || ! wp_verify_nonce( $_GET['_wpnonce'], 'delete_event' )
        ) {

	        Admin_Notice::create('error', __('The WPnonce didn\'t verify please try again!', $this->plugin_text_domain));
	        echo $this->templates->render('html-event-referer'); // render views/html-event-referer.php

        } else {

            if (isset($_POST['action'])) {
                if ( // check wpnonce -> to verify the validity of the form
                    ! isset( $_POST['_wpnonce_delete_event'] )
                    || ! wp_verify_nonce( $_POST['_wpnonce_delete_event'], 'delete_event_confirmation' )
                ) {

	                Admin_Notice::create('error', __('The WPnonce didn\'t verify please try again!', $this->plugin_text_domain));
	                echo $this->templates->render('html-event-referer'); // render views/html-event-referer.php

                } else { // delete event after validation
                    $event = Event::findbyId($_POST['event']);
                    $event->delete();

	                Admin_Notice::create('success', sprintf(esc_html__( 'Successfully deleted the Event %s', $this->plugin_text_domain ), $event->getName()));

                    echo $this->templates->render('html-event-referer'); // render views/html-event-referer.php
                }
            } else { // ask: do you really want to delete the event

                $event = Event::findbyId($_GET['event']);
                echo $this->templates->render('html-event-delete',[ // render views/html-event-delete.php
                    'title'         => __('Delete Kitchen Run Event', $this->plugin_text_domain),
                    'event'         => $event,
                    'confirm_delete'=> __('You have specified this event for deletion: ', $this->plugin_text_domain),
                    'submit'        => __('Confirm Deletion', $this->plugin_text_domain),
                ]);
            }
        }
    }
}