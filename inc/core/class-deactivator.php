<?php

namespace KitchenRun\Inc\Core;

use KitchenRun\Inc\Common\Model\Database;

/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * Based on Plugin Boilerplate for Wordpress Plugin Creation from "@source".
 * @source https://github.com/karannagupta/WordPress-Plugin-Boilerplate
 *
 * @since      1.0.0
 *
 * @author     Niklas Loos <niklas.loos@live.com>
 **/
class Deactivator {

	/**
	 * Deactivator Function. Runs when plugin is deactivated.
	 *
	 * The functions is executed after the plugins get deactivated by a user.
     * It will drop all plugin specific database tables.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        //$database = new Database();
        //$database->kr_team_uninstall();
        //$database->kr_pair_uninstall();
        //$database->kr_event_uninstall();
	}

}
