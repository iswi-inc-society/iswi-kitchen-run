<?php


/*

// Database Class
use KitchenRun\Backend\KrAdminMenu;
use KitchenRun\Database\KrDatabase;
use KitchenRun\Frontend\KrSignup;

require_once(__DIR__ . "/include/KrDatabase.php");
require_once(__DIR__ . "/include/KrSignup.php");
require_once(__DIR__ . "/include/KrAdminMenu.php");

// creates the tables in db when plugin is activated (wp hook)
register_activation_hook( __FILE__, 'createDatabases' );
//register_deactivation_hook(__FILE__, 'dropDatabases');

register_uninstall_hook(__FILE__, 'dropDatabases');

add_shortcode( 'kitchenrun', 'createSignUpForm' );

//load admin menu
$admin_menu = new KrAdminMenu();

function createSignUpForm() {
    $signup = new KrSignup();
    return $signup->render();
}
*/

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since      1.0.0
 * @author     Niklas Loos <niklas.loos@live.com>
 *
 * @wordpress-plugin
 * Plugin Name:       Kitchen Run
 * Plugin URI:        https://github.com/XRayLP/iswi-kitchen-run
 * Description:       Kitchen Run Plugin for Wordpress
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Niklas Loos
 * Author URI:        https://github.com/XRayLP
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kitchen-run
 */

namespace KitchenRun;

// If this file is called directly, abort.
use KitchenRun\Inc\Core\Init;

if (!defined('WPINC')) {
    die;
}

/**
 * Define Constants
 */

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

define(NS . 'PLUGIN_NAME', 'kitchenrun');

define(NS . 'PLUGIN_VERSION', '1.0.0');

define(NS . 'PLUGIN_NAME_DIR', plugin_dir_path(__FILE__));

define(NS . 'PLUGIN_NAME_URL', plugin_dir_url(__FILE__));

define(NS . 'PLUGIN_BASENAME', plugin_basename(__FILE__));

define(NS . 'PLUGIN_TEXT_DOMAIN', 'kitchenrun');


/**
 * Autoload Classes
 */

require_once(PLUGIN_NAME_DIR . 'inc/libraries/autoloader.php');

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in inc/core/class-activator.php
 */

register_activation_hook(__FILE__, array(NS . 'Inc\Core\Activator', 'activate'));

/**
 * The code that runs during plugin deactivation.
 * This action is documented inc/core/class-deactivator.php
 */

register_deactivation_hook(__FILE__, array(NS . 'Inc\Core\Deactivator', 'deactivate'));


/**
 * Plugin Singleton Container
 *
 * Maintains a single copy of the plugin app object
 *
 * @since    1.0.0
 */
class KitchenRun
{

    /**
     * The instance of the plugin.
     *
     * @since    1.0.0
     * @var      Init $init Instance of the plugin.
     */
    private static $init;

    /**
     * Loads the plugin
     *
     * @access    public
     */
    public static function init()
    {

        if (null === self::$init) {
            self::$init = new Inc\Core\Init();
            self::$init->run();
        }

        return self::$init;
    }

}

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * Also returns copy of the app object so 3rd party developers
 * can interact with the plugin's hooks contained within.
 **/
function kitchenrun_init()
{
    return KitchenRun::init();
}

$min_php = '5.6.0';

// Check the minimum required PHP version and run the plugin.
if (version_compare(PHP_VERSION, $min_php, '>=')) {
    kitchenrun_init();
}