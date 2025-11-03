<?php
/**
 * "WPtimize" is a plugin for resizing and optimizing images uploaded to WordPress
 * 
 *
 * @package           wptimize
 *
 * @wordpress-plugin
 * Plugin Name:       WPtimize
 * Plugin URI:        https://kloudboy.com/wptimize
 * Description:       Optimize images uploaded to the server. Go to "tools" to configure the plugin or to perform batch optimization. Go to "Media library (list view)" to optimize individual images.
 * Version:           2.0.1
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            KloudBoy
 * Author URI:        https://kloudboy.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: 	  wptimize
 * Domain Path: 	  /languages
 */

 namespace wptimize;

 // Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
 define('WPTIMIZE_VERSION', '2.0.1');
 define('WPTIMIZE_DIR', plugin_dir_path( __FILE__ ) );

require __DIR__ . '/includes/class-bir-extends-function.php';
require __DIR__ . '/includes/class-bir-rename-function.php';
require __DIR__ . '/includes/class-bir-rebuild-function.php';
require __DIR__ . '/includes/class-bir-optimize-function.php';
require __DIR__ . '/includes/class-bir-list-function.php';
require __DIR__ . '/includes/class-bir-options-vars.php';
require __DIR__ . '/includes/class-bir-loader.php';
require __DIR__ . '/includes/class-bir-upload-new-file.php';
require __DIR__ . '/includes/class-bir-loader-media-library.php';
require __DIR__ . '/includes/class-bir-facade.php';
require __DIR__ . '/includes/class-bir-functions.php';
require __DIR__ . "/admin/class-wptimize-admin.php";

$bir_options = new Bir_options_var();
$admin = new Wptimize_admin();


// Chiamo la funzione op_activate quando il plugin viene attivato

// Load plugin text domain for translations
add_action('plugins_loaded', function() {
    load_plugin_textdomain('wptimize', false, dirname(plugin_basename(__FILE__)) . '/languages');
});


/**
 * Quando viene rimosso il plugin
 */
 function wptimize_loader_uninstall() {
     global $wpdb;
     // v. 1.2.0
    delete_option('op_resize_statistics');
    delete_option('wptimize');
    delete_option('op_resize_images_done');
    delete_option('wptimize_welcome');
    // v. 2.0
    // rimuovo tutte le info meta
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_bir_attachment_originalname'");
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_bir_attachment_originaltitle'");
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_bir_attachment_uniqid'");
    $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_bir_attachment_originalfilesize'");

}

/**
 * Quando viene attivato il plugin
 */
function wptimize_loader_activate() {
    update_option('wptimize_welcome', 1, false);
}



\register_uninstall_hook(__FILE__, '\wptimize\wptimize_loader_uninstall');
\register_activation_hook( __FILE__,  '\wptimize\wptimize_loader_activate' );

