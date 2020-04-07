<?php

namespace KitchenRun\Inc\Core;

use KitchenRun\Inc\Common\Model\Database;

/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * Based on Plugin Boilerplate for Wordpress Plugin Creation from "@source".
 * @source https://github.com/karannagupta/WordPress-Plugin-Boilerplate
 *
 * @since      1.0.0
 *
 * @author     Niklas Loos <niklas.loos@live.com>
 **/
class Activator {

	/**
	 * Activator Function. Runs when Plugin is activated.
	 *
	 * When the Plugin is activated this function is executed. It checks the PHP Version and creates all the Plugin
     * specific database tables.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

			$min_php = '5.6.0';

		// Check PHP Version and deactivate & die if it doesn't meet minimum requirements.
		if ( version_compare( PHP_VERSION, $min_php, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'This plugin requires a minmum PHP Version of ' . $min_php );
		}

		// create plugin specific db tables
        $database = new Database();
        $database->kr_team_install();
        $database->kr_pair_install();
        $database->kr_event_install();

	}

}
