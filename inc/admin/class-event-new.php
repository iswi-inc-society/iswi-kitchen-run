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
class Event_New
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
     * Templating Engine Plates
     *
     * @since   1.0.0
     * @access  private
     * @var     Engine  $templates
     */
    private $templates;

    /**
     * Array of Messages that are created during the process.
     *
     * @since   1.0.0
     * @access  private
     * @var     string[]    $messages
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

        $this->templates = new Engine(__DIR__ . '/views');

    }

    /**
     * Initialization Method that is called after the page is chosen.
     * Called by add_plugin_admin_menu() in Class Admin.
     *
     * @since 1.0.0
     */
    public function init() {

        // form is submitted
        if(isset($_POST['event_submit'])) {
            if ( // check wpnonce -> to verify the validity of the form
                ! isset( $_POST['_wpnonce_add_event'] )
                || ! wp_verify_nonce( $_POST['_wpnonce_add_event'], 'add_event' )
            ) {

                print 'Sorry, your nonce did not verify.';
                exit;

            } else { // wpnonce successfully checked -> validated

                // process form data
                $opening_date = $_POST['opening_date'].' '.$_POST['opening_time'].':00';
                $closing_date = $_POST['closing_date'].' '.$_POST['closing_time'].':00';
                $event_date = $_POST['event_date'].' '.$_POST['event_time'].':00';

                try { // testing date format and create date objects
                    $opening_date = new DateTime($opening_date);
                    $closing_date = new DateTime($closing_date);
                    $event_date = new DateTime($event_date);
                } catch (Exception $e) {
                    echo 'Datetime has false Format';
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
                        $old_current->setCurrent(0);
                        $old_current->save();

                    } else {
                        $event->setCurrent(0);
                    }

                    $event->setManager(get_userdata(get_current_user_id())); //set current user as manager

                    $event->setName($_POST['event_name']);

                    $event->setPaired(0);

                    $event->save();

                    echo $this->templates->render('html-event-referer'); // js referer

                } else { // opening date after closing date
                    $this->messages[] =  __( 'Please enter an Opening Date that takes place before the Closing Date. The Event Date has to take place after the Closing Date!', $this->plugin_text_domain );
                }
            }
        }

        // create wp_nonce field
        ob_start();
        wp_nonce_field( 'add_event', '_wpnonce_add_event' );
        $wp_nonce = ob_get_clean();

        echo $this->templates->render('html-new-event-form', [ // render views/html-new-event-form.php
            'title'         => __('New Kitchen Run Events', $this->plugin_text_domain),
            'messages'      => $this->messages,
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