<?php

namespace KitchenRun\Inc\Core;
use KitchenRun;
use KitchenRun\Inc\Admin as Admin;
use KitchenRun\Inc\Frontend as Frontend;

/**
 * The core plugin class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Based on Plugin Boilerplate for Wordpress Plugin Creation from "@source".
 * @source https://github.com/karannagupta/WordPress-Plugin-Boilerplate
 *
 * @since      1.0.0
 *
 * @author     Niklas Loos <niklas.loos@live.com>
 */
class Init {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_base_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_basename;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The ID of this plugin.
     */
    protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The text domain of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $plugin_text_domain;

	/**
	 * Initialize and define the core functionality of the plugin.
	 */
	public function __construct() {

		$this->plugin_name = KitchenRun\PLUGIN_NAME;
		$this->version = KitchenRun\PLUGIN_VERSION;
		$this->plugin_basename = KitchenRun\PLUGIN_BASENAME;
		$this->plugin_text_domain = KitchenRun\PLUGIN_TEXT_DOMAIN;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcodes();


	}

	/**
	 * Loads the following required dependencies for this plugin.
	 *
	 * - Loader - Orchestrates the hooks of the plugin.
	 * - Internationalization_I18n - Defines internationalization functionality.
	 * - Admin - Defines all hooks for the admin area.
	 * - Frontend - Defines all hooks for the public side of the site.
	 *
	 * @access    private
	 */
	private function load_dependencies() {
		$this->loader = new Loader();


	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	private function set_locale() {

		$plugin_i18n = new Internationalization_I18n( $this->plugin_text_domain );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
		$this->loader->add_action('admin_init', $plugin_admin, 'add_admin_settings');
		$this->loader->add_action('init', $plugin_admin, 'kr_start_session');
		$this->loader->add_action('init', $plugin_admin, 'adjust_roles');
		$this->loader->add_action('wp_logout', $plugin_admin, 'kr_stop_session');
		$this->loader->add_action('wp_login', $plugin_admin, 'kr_stop_session');


		/*
		 * Additional Hooks go here
		 *
		 * e.g.
		 *
		 * //admin menu pages
		 * $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
		 *
		 *  //plugin action links
		 * $this->loader->add_filter( 'plugin_action_links_' . $this->plugin_basename, $plugin_admin, 'add_additional_action_link' );
		 *
		 */
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @access    private
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend\Frontend( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );
		$signup = new Frontend\Signup( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );
		

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 99 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'init' , $plugin_public, 'gutenberg_kitchenrun_signup_register_block');

		#$signup = new Signup( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );
		$this->loader->add_action( 'wp_ajax_kr_signup_submit', $signup, 'submit');
		$this->loader->add_action( 'wp_ajax_nopriv_kr_signup_submit', $signup, 'submit');

	}


    /**
     * Register all shortcodes to generate html code in the frontend
     *
     * @access private
     */
    private function define_shortcodes() {
        $plugin_public = new Frontend\Frontend( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain() );

        /**
         * @deprecated use gutenberg block
         */
        add_shortcode( 'kitchenrun', array($plugin_public, 'signup_page') ); // shortcode for sign up form
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the text domain of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The text domain of the plugin.
	 */
	public function get_plugin_text_domain() {
		return $this->plugin_text_domain;
	}



}
