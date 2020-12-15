<?php

namespace KitchenRun\Inc\Admin;

use League\Plates\Engine;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * Based on Plugin Boilerplate for Wordpress Plugin Creation from "@source".
 * @source https://github.com/karannagupta/WordPress-Plugin-Boilerplate
 *
 * @since       1.0.0
 * @package     KitchenRun\Inc\Admin
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_text_domain    The text domain of this plugin.
	 */
	protected $plugin_text_domain;

	/**
	 * Templating Engine Object, used to create nice templates!
	 *
	 * @var Engine Templating Engine
	 */
	protected $templates;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since       1.0.0
	 * @param       string $plugin_name        The name of this plugin.
	 * @param       string $version            The version of this plugin.
	 * @param       string $plugin_text_domain The text domain of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_text_domain ) {

		$this->plugin_name        = $plugin_name;
		$this->version            = $version;
		$this->plugin_text_domain = $plugin_text_domain;
		$this->templates          = new Engine( __DIR__ . '/views' );
	}

	/**
	 * Displays Content, use echo to display!
	 */
	public function init() {}

	/**
	 * Checks a wpnonce and returns true if valid, else it refers if referer is set.
	 * field needs to have
	 *
	 * @param   $name       string  Name of checked wpnonce
	 * @param   $referer    string  referer name, needs to be under views/referer
	 *
	 * @return bool
	 */
	protected function verify_nonce($name, $field_name = '_wpnonce',  $referer = null) {
		if (
			( //check the wpnonce field of GET or POST
				! isset( $_GET[$field_name] )
				|| ! wp_verify_nonce( $_GET[$field_name], $name )
			)&&(
				! isset($_POST[$field_name])
				|| ! wp_verify_nonce( $_POST[$field_name], $name)
			)

		) {

			Admin_Notice::create( 'error', __( 'The WPnonce didn\'t verify please try again!', $this->plugin_text_domain ) );
			if (isset($referer)) echo $this->templates->render( 'referer/' . $referer ); // render views/referer

			return false;
		} else return true;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public final function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-kitchenrun-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public final function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-kitchenrun-admin.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * Callback for the user sub-menu in define_admin_hooks() for class Init.
     *
     * @since    1.0.0
     */
    public final function add_plugin_admin_menu() {


        /**
         * Admin Page Objects
         */
        $event_page_page = new Event_Page($this->plugin_name, $this->version, $this->plugin_text_domain);
        $event_new = new Event_New($this->plugin_name, $this->version, $this->plugin_text_domain);
        $team_page_page = new Team_Page($this->plugin_name, $this->version, $this->plugin_text_domain);
        $settings_page = new Settings_Page($this->plugin_name, $this->version, $this->plugin_text_domain);

        /**
         * Admin Menus
         */
        add_menu_page( //kitchenrun top menu
            __( 'Kitchen Run', $this->plugin_text_domain ),
            __( 'Kitchen Run', $this->plugin_text_domain ),
            'kitchen_run',
            $this->plugin_name,
            array($event_page_page, 'init'),
            'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGQ9Ik0zODQuMDgyLDYwLjA0OGMtOS4wNDIsMC0xNy45NTEsMS4wNi0yNi42MjQsMy4xNkMzMzguNjg3LDI0Ljg3OCwyOTkuNTU2LDAsMjU2LDANCgkJCWMtNDMuNTU2LDAtODIuNjg3LDI0Ljg3OC0xMDEuNDU4LDYzLjIwOGMtOC42NzMtMi4xLTE3LjU4Mi0zLjE2LTI2LjYyNC0zLjE2Yy02Mi4yOTMsMC0xMTIuOTczLDUwLjY3OS0xMTIuOTczLDExMi45NzMNCgkJCWMwLDU3LjIxLDQyLjc0MiwxMDQuNjI0LDk3Ljk3MywxMTEuOTgxdjEzNi45NTFoODUuMzg4di0xNTAuOTZoMzB2MTUwLjk1OWg1NS4zODhWMjcwLjk5M2gzMHYxNTAuOTU5aDg1LjM4OFYyODUuMDAxDQoJCQljNTUuMjMtNy4zNTcsOTcuOTczLTU0Ljc3MSw5Ny45NzMtMTExLjk4QzQ5Ny4wNTUsMTEwLjcyOCw0NDYuMzc2LDYwLjA0OCwzODQuMDgyLDYwLjA0OHoiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHJlY3QgeD0iMTEyLjkyIiB5PSI0NTEuOTUiIHdpZHRoPSIyODYuMTYiIGhlaWdodD0iNjAuMDUiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==',
            20
        );

        $event_page = add_submenu_page( //event submenu
            $this->plugin_name,
            __( 'Events', $this->plugin_text_domain ),
            __( 'Events', $this->plugin_text_domain ),
            'kitchen_run',
            $this->plugin_name,
            array($event_page_page, 'init'),
            20
        );


        add_submenu_page( // create new event submenu
            $this->plugin_name,
            __( 'Add Event', $this->plugin_text_domain ),
            __( 'Add Event', $this->plugin_text_domain ),
            'kitchen_run',
            $this->plugin_name.'_add_event',
            array($event_new, 'init'),
            20
        );

        $teams_page = add_submenu_page( // teams submenu
            $this->plugin_name,
            __( 'Teams', $this->plugin_text_domain ),
            __( 'Teams', $this->plugin_text_domain ),
            'kitchen_run',
            $this->plugin_name.'_teams',
            array($team_page_page, 'init'),
            20
        );


        add_submenu_page(
            $this->plugin_name,
            __( 'Settings', $this->plugin_text_domain ),
            __( 'Settings', $this->plugin_text_domain ),
            'kitchen_run',
            $this->plugin_name.'_settings',
            array($settings_page, 'init')
        );


        /*
         * The $page_hook_suffix can be combined with the load-($page_hook) action hook
         * https://codex.wordpress.org/Plugin_API/Action_Reference/load-(page)
         *
         * The callback below will be called when the respective page is loaded
         */
        add_action( 'load-'.$event_page, array( $event_page_page, 'load_event_list_table_screen_options' ) );
        add_action( 'load-'.$teams_page, array( $team_page_page, 'load_team_list_table_screen_options' ) );

    }

    /**
     * Callback for the settings sub-menu in define_admin_hooks() for class Init.
     *
     * @since    1.0.0
     */
    public final function add_admin_settings() {

        $settings_page = new Settings_Page($this->plugin_name, $this->version, $this->plugin_text_domain);

        // register a new setting for "kitchenrun_settings" page
        register_setting('kitchenrun', 'kitchenrun_email');
        register_setting('kitchenrun', 'kitchenrun_email_name');
        register_setting('kitchenrun', 'kitchenrun_contact_email');

        // register a new section in the "kitchenrun_settings" page
        add_settings_section(
            'kitchenrun_email_section',
            __('E-Mail Settings', $this->plugin_text_domain),
            null,
            $this->plugin_name.'_settings'
        );

        // register fields for email section
        // email field
        add_settings_field(
            'kitchenrun_field_email',
            __('E-Mail', $this->plugin_text_domain),
            array($settings_page, 'email_field_cb'),
            $this->plugin_name.'_settings',
            'kitchenrun_email_section',
            [
                'label_for' => 'kitchenrun_email',
                'class' => 'kitchenrun_row',
            ]
        );

        // email name field
        add_settings_field(
            'kitchenrun_field_email_name',
            __('E-Mail Name', $this->plugin_text_domain),
            array($settings_page, 'email_name_field_cb'),
            $this->plugin_name.'_settings',
            'kitchenrun_email_section',
            [
                'label_for' => 'kitchenrun_email_name',
                'class' => 'kitchenrun_row',
            ]
        );

        //contact email field
        add_settings_field(
            'kitchenrun_field_contact_email',
            __('Contact E-Mail', $this->plugin_text_domain),
            array($settings_page, 'contact_email_field_cb'),
            $this->plugin_name.'_settings',
            'kitchenrun_email_section',
            [
                'label_for' => 'kitchenrun_contact_email',
                'class' => 'kitchenrun_row',
            ]
        );
    }

    public final function adjust_roles() {
        $role = get_role('editor')	;
        $role->add_cap('kitchen_run', true);

	    $role = get_role('administrator')	;
	    $role->add_cap('kitchen_run', true);
    }

	public final function kr_start_session() {
		if(!session_id()) {
			session_start();
		}
	}

	public final function kr_stop_session() {
		session_destroy ();
	}









}
