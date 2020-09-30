<?php

namespace KitchenRun\Inc\Frontend;

use DateTime;
use League\Plates\Engine;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * Based on Plugin Boilerplate for Wordpress Plugin Creation from "@source".
 * @source https://github.com/karannagupta/WordPress-Plugin-Boilerplate
 *
 * @since       1.0.0
 * @package     KitchenRun\Inc\Admin
 * @author      Niklas Loos <niklas.loos@live.com>
 */
class Frontend {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-kitchenrun-signup.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( "jQuery-validate", plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-kitchenrun-signup.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * Renders the Frontend Page for the current Kitchen Run Event.
     * @deprecated Shortcode is used to add it to the frontend, see define_shortcodes() in the Init Class.
     * Use now the Gutenberg Block to add it to the frontend.
     *
     * The functions renders for each possible status of the event a message and when the sign up form is open it will render it to.
     *
     * @since 1.0.0
     */
	public function signup_page()
    {

    }

    /**
     * Registers Gutenberg Block to add signup page for current Kitchenrun Event to the frontend.
     *
     * @TODO    Approve Gutenberg Block
     */
    function gutenberg_kitchenrun_signup_register_block()
    {
        if ( ! function_exists( 'register_block_type' ) ) {
            // Gutenberg is not active.
            return;
        }

        // dependencies for the js block
        $dep = array('wp-api-fetch', 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n', 'wp-polyfill');

        // register the script for the block
        wp_register_script(
            'gutenberg-kitchenrun-signup',
            plugins_url( 'js/gutenberg-kitchenrun-signup.js', __FILE__ ),
            $dep,
            filemtime( plugin_dir_path( __FILE__ ) . 'js/gutenberg-kitchenrun-signup.js' )
        );

        // stylesheet for block
        wp_register_style('gutenberg-kitchenrun-signup',
            plugins_url( 'css/wp-kitchenrun-editor.css', __FILE__ ),
            array( 'wp-edit-blocks' ),
            filemtime( plugin_dir_path( __FILE__ ) . 'css/wp-kitchenrun-editor.css' )
        );

        $signup = new Signup($this->plugin_name, $this->version, $this->plugin_text_domain, true);

        // register the block for editor
        register_block_type( 'kitchenrun/signup', array(
            'render_callback' => array($signup, 'init'), // rendering for frontend
            'editor_script' => 'gutenberg-kitchenrun-signup',
            'editor_style'  => 'gutenberg-kitchenrun-signup',
        ) );

        if ( function_exists( 'wp_set_script_translations' ) ) {
            /**
             * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
             * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
             * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
             */
            wp_set_script_translations( 'gutenberg-kitchenrun-signup', 'kitchen-run' );
        }

    }

}
