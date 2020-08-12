<?php


namespace KitchenRun\Inc\Admin;

use League\Plates\Engine;

/**
 * Class Team_Page
 * Processes all requests from the Settings Submenu.
 *
 * @author Niklas Loos <niklas.loos@live.com>
 * @package KitchenRun\Inc\Admin
 * @since 1.0.0
 */
class Settings_Page
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
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'kitchenrun_messages', 'wporg_message', __( 'Settings Saved', $this->plugin_text_domain ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'kitchenrun_messages' );

        echo $this->templates->render('html-settings', [
            'title' => get_admin_page_title(),
        ]);
    }

    /**
     * Callback function to render the email settings field. Called in Admin add_admin_settings().
     *
     * @since 1.0.0
     * @param array $args Array of arguments defined during the register of the field
     */
    public function email_field_cb ( $args ) {
        $description = __('Sets the E-Mail address mails are sent from. It needs to be the E-Mail address that is 
            configured in the servers smtp configuration.', $this->plugin_text_domain);

        $this->text_field_cb($args['label_for'], $description);
    }

    /**
     * Callback function to render the email name settings field. Called in Admin add_admin_settings().
     *
     * @since 1.0.0
     * @param array $args Array of arguments defined during the register of the field
     */
    public function email_name_field_cb ( $args ) {
        $description = __('Sets the Email Name that the people will see as the name of the Address.', $this->plugin_text_domain);

        $this->text_field_cb($args['label_for'], $description);
    }


    /**
     * Callback function to render the contact email settings field. Called in Admin add_admin_settings().
     *
     * @since 1.0.0
     * @param array $args Array of arguments defined during the register of the field
     */
    public function contact_email_field_cb ( $args ) {
        $description = __('Sets the contact email that is shown in the frontend. Frontend user should be able to contact this mail in case they have questions or problems.', $this->plugin_text_domain);

        $this->text_field_cb($args['label_for'], $description);
    }

    /**
     * Render a text field for the settings menu.
     *
     * @since 1.0.0
     * @param string $label_for    Label ID and Name ID for the field
     * @param string $description  Description of the field. Should be already translated.
     */
    private function text_field_cb( $label_for, $description = null) {
        $value = get_option( $label_for );

        $args = [
            'label_for' => $label_for,
            'value' => $value,
        ];

        if (isset($description))
            $args['description'] = $description;

        echo $this->templates->render('settings/html-settings-text', $args);
    }
}