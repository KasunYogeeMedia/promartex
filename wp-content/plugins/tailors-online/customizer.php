<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/codezel
 * @since             1.0
 * @package           Tailors Online
 *
 * @wordpress-plugin
 * Plugin Name:       Tailors Online
 * Plugin URI:        https://themeforest.net/user/codezel
 * Description:       This plugin is used for Tailors to get orders online.
 * Version:           2.1.4
 * Author:            CodeZel
 * Author URI:        https://themeforest.net/user/codezel
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tailors-online
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elevator-activator.php
 */
if (!function_exists('activate_tailors_online')) {

    function activate_tailors_online() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-alteration-activator.php';
        TailorsOnline_Activator::activate();
    }

}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elevator-deactivator.php
 */
if (!function_exists('deactivate_tailors_online')) {

    function deactivate_tailors_online() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-alteration-deactivator.php';
        TailorsOnline_Deactivator::deactivate();
    }

}

register_activation_hook(__FILE__, 'activate_tailors_online');
register_deactivation_hook(__FILE__, 'deactivate_tailors_online');

/**
 * Plugin configuration file,
 * It include getter & setter for global settings
 */
require_once plugin_dir_path(__FILE__) . 'config.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path(__FILE__) . 'includes/class-alteration.php';
require_once plugin_dir_path(__FILE__) . '/helpers/constants.php';
require_once plugin_dir_path(__FILE__) . '/public/hooks.php';
require_once plugin_dir_path(__FILE__) . '/public/functions.php';
require_once plugin_dir_path(__FILE__) . '/woocommerce/class-woocommerce.php';


ob_start();
if ( ! session_id() ) {
	session_start();
}
ob_clean();


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0
 */
if (!function_exists('run_TailorsOnline')) {

    function run_TailorsOnline() {

        $plugin = new TailorsOnline();
        $plugin->run();
    }

    run_TailorsOnline();
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
add_action( 'init', 'tailors_online_load_textdomain' );
function tailors_online_load_textdomain() {
  load_plugin_textdomain( 'tailors-online', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}