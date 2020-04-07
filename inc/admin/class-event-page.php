<?php


namespace KitchenRun\Inc\Admin;


use KitchenRun\Inc\Common\Model\Event;

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
     * Event Object for updating or deleting events
     *
     * @since   1.0.0
     * @access  private
     * @var     Event   $event  Event Object
     */
    private $event;

    /**
     * Event List Object to create the list of events
     *
     * @since   1.0.0
     * @access  private
     * @var     Event_List_Table    $event_table
     */
    private $event_table;

    /**
     * @var string[]
     */
    private $messages = array();


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

    }

    /**
     * Initialization Method that is called after the page is choosen.
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

        // render the List Table
        include_once('views/html-event-list.php');
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

                print 'Sorry, your nonce did not verify.';
                exit;

            } else { // wpnonce successfully checked

                $event = Event::findbyId($_POST['event_id']);

                // process form data
                if (isset($_POST['opening_date']) && isset($_POST['opening_time'])) {
                    $opening_date = $_POST['opening_date'] . ' ' . $_POST['opening_time'] . ':00';
                }

                if (isset($_POST['closing_date']) && isset($_POST['closing_time'])) {
                    $closing_date = $_POST['closing_date'] . ' ' . $_POST['closing_time'] . ':00';
                }
                if (isset($_POST['event_date']) && isset($_POST['event_time'])) {
                    $event_date = $_POST['event_date'] . ' ' . $_POST['event_time'] . ':00';
                }

                try { // testing date format and create date objects
                    $opening_date = new \DateTime($opening_date);
                    $closing_date = new \DateTime($closing_date);
                    $event_date = new \DateTime($event_date);
                } catch (\Exception $e) {
                    echo 'Datetime has false Format';
                }

                // is opening date befor closing date?
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

                    include_once('views/html-event-referer.php');

                } else { // render form
                    $event = Event::findbyId($_GET['event']); // needed in view
                    include_once('views/html-event-update-form.php');
                }
            }
        } else { // render form
            $event = Event::findbyId($_GET['event']); // needed in view
            include_once('views/html-event-update-form.php');
        }
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

            print 'Sorry, your nonce did not verify.';
            exit;

        } else {

            if (isset($_POST['action'])) {
                if ( // check wpnonce -> to verify the validity of the form
                    ! isset( $_POST['_wpnonce_delete_event'] )
                    || ! wp_verify_nonce( $_POST['_wpnonce_delete_event'], 'delete_event_confirmation' )
                ) {

                    print 'Sorry, your nonce did not verify.';
                    exit;

                } else { // delete event after validation
                    $event = Event::findbyId($_POST['event']);
                    $event->delete();

                    include_once('views/html-event-referer.php');
                }
            } else { // ask: do you really want to delete the event
                $event = Event::findbyId($_GET['event']);
                include_once('views/html-event-delete.php');
            }
        }
    }
}