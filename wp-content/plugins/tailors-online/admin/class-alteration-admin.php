<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/admin
 * @author     CodeZel <thecodezel@gmail.com>
 */
class TailorsOnline_Admin {

    public function __construct() {
        $this->plugin_name = TailorsOnlineGlobalSettings::get_plugin_name();
        $this->version = TailorsOnlineGlobalSettings::get_plugin_verion();
        $this->plugin_path = TailorsOnlineGlobalSettings::get_plugin_path();
        $this->plugin_url = TailorsOnlineGlobalSettings::get_plugin_url();
        $this->prepare_post_types();
		//add_action( 'plugins_loaded', array(&$this, 'tailors_online_plugins_loaded') );
    }

    /**
     * Plugin loaded
     *
     * @since    1.0
     */
    public function tailors_online_plugins_loaded() {
         //$this->prepare_post_types();
    }
	
	/**
     * Register the spost types for the admin area.
     *
     * @since    1.0
     */
    public function prepare_post_types() {
        $dir = $this->plugin_path;
        $scan_PostTypes = glob($dir."/admin/post-types/*");
        foreach ($scan_PostTypes as $filename) {
            @require_once $filename;
        }
    }

    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style('font-awesome.min', $this->plugin_url . 'admin/css/font-awesome.min.css', array(), $this->version, 'all');
        wp_enqueue_style('icomoon', $this->plugin_url . 'public/css/icomoon.css', array(), $this->version, 'all');
        wp_enqueue_style('tailors-online-styles-main', $this->plugin_url . 'admin/css/main.css', array(), $this->version, 'all');
		wp_enqueue_style( 'wp-color-picker' ); 	
    }

    /**
     * Register the JavaScript for the admin area.
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
        wp_enqueue_media();
        wp_enqueue_script('wp-util,jquery-ui');
        wp_enqueue_script('tailors_online_lib', $this->plugin_url . 'admin/js/lib.js', array(), $this->version, false);
        wp_enqueue_script('tailors_online_scripts', $this->plugin_url . 'admin/js/functions.js', array(), $this->version, false);
        wp_enqueue_script('tailors_online_scripts_main', $this->plugin_url . 'admin/js/main.js', array('jquery','wp-color-picker'), $this->version, true);
        wp_enqueue_script('tailors_online_customizer_media_uploader', $this->plugin_url . 'admin/js/customizer.media.uploader.js', array(), $this->version, true);
		
        wp_localize_script('tailors_online_scripts', 'scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
			'del_apparel_title' => esc_html__('Delete apparel?','tailors-online'),
			'del_apparel_message' => esc_html__('Are you sure you want to delete this apparel?','tailors-online'),
			'del_step_title' => esc_html__('Delete Step?','tailors-online'),
			'del_step_message' => esc_html__('Are you sure you want to delete this step?','tailors-online'),
			'settings_saved' => esc_html__('Your settings has saved.','tailors-online'),
        ));
    }
}