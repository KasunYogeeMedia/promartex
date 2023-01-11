<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 * @author     CodeZel <thecodezel@gmail.com>
 */
class TailorsOnline_Public {

	
	public function __construct() {

		$this->plugin_name = TailorsOnlineGlobalSettings::get_plugin_name();
        $this->version     = TailorsOnlineGlobalSettings::get_plugin_verion();
        $this->plugin_path = TailorsOnlineGlobalSettings::get_plugin_path();
        $this->plugin_url  = TailorsOnlineGlobalSettings::get_plugin_url();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TailorsOnline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TailorsOnline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'tailors_online_public', plugin_dir_url( __FILE__ ) . 'css/alteration-public.css', array(), $this->version, 'all' );

		$css['font-awesome.min']    = 'font-awesome.min.css';
		$css['icomoon'] 			= 'icomoon.css';
		$css['responsive'] 		 	= 'responsive.css';
		$css['transitions']			= 'transitions.css';

		foreach ($css as $key => $file) {
			wp_enqueue_style( $key, plugin_dir_url( __FILE__ ) . 'css/'.$file, array(), $this->version, 'all' );
		}
		
		$custom_css    = cus_get_dynamic_style();
        wp_add_inline_style( 'tailors_online_public', $custom_css );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TailorsOnline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TailorsOnline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$js['modernizr-2.8.3'] = 'vendor/modernizr-2.8.3-respond-1.4.2.min.js';
		$js['sticky-kit'] 	  = 'sticky-kit.js';
		$js['customizer_main'] = 'main.js';
		foreach ($js as $key => $file) {
			wp_enqueue_script( $key, plugin_dir_url( __FILE__ ) . 'js/'.$file, array('jquery'), $this->version, false );
		}
		
		$force_measurement	= get_option('wp_customizer_force');

		wp_localize_script('customizer_main', 'wp_localize_tailors', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
			'confirm_garment_title' => esc_html__('Process order?','tailors-online'),
			'force_measurement' => $force_measurement,
			'force_measurement_message' => esc_html__('Please add measurements before process this order.','tailors-online'),
			'confirm_garment_message' => esc_html__('Are you sure you want to process this order?','tailors-online'),
        ));

	}

}