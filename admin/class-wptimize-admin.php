<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

namespace wptimize;

class Wptimize_admin 
{
    public function __construct() {
        add_action( 'admin_menu',  [$this, 'opbir_add_admin_menu'] );
    }
   
	 /**
	 * NUOVO
     * Carico il template della pagina
     * Questa funzione viene caricata solo se sei nella pagina del plugin!
     */
    function get_template() {
		global $bir_options;
        wp_enqueue_style( 'bir-style' , plugin_dir_url( __FILE__ ) . 'css/bir.css');
 	    wp_enqueue_script( 'wptimize-chart', plugin_dir_url( __FILE__ ) . 'js/chart.js');
 	    wp_enqueue_script( 'bir-js'   , plugin_dir_url( __FILE__ ) . 'js/bir.js');
		$options = $bir_options;
		$check_fn_editor = Bir_functions::check_image_editor();
        require_once(plugin_dir_path(__FILE__)."template/class-config-functions.php");
		require (plugin_dir_path(__FILE__)."template/bir-container.php");
    }
    /**
	 * Importo la voce di menu nell'amministrazione
	 */
	public function opbir_add_admin_menu() {
		add_management_page(
			__('WPtimize', 'wptimize'),
			'WPtimize',
			'manage_options',
			'wptimize',
			[$this, 'get_template']
		);
	}
}
