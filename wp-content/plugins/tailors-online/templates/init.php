<?php
if (!class_exists('WpCustomizer_Public_Hooks')) {

    class WpCustomizer_Public_Hooks {

        /**
         * @access          public
         * @init            Admin Hooks
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Construct All hooks and run them in object creation.
         */
        public function __construct() {
            add_shortcode('wp_customizer', array(&$this, 'wp_customizer_shortcode'));
			add_shortcode('wp_measurements', array(&$this, 'wp_measurements_shortcode'));
        }
		
		/**
		 * Customizer page
		 *
		 * @since 1.0
		*/
        public function wp_customizer_shortcode($atts) {
            global $wpdb, $product;
			
			if( empty( $_GET['pid'] ) ){
				return;
			}
			
			//Get the Product ID
            $product_id = $_GET['pid'];
			$customizer_id	= apply_filters('cu_get_customizer_by_product',$product_id);
 		
			if( empty( $customizer_id ) ){
				return;
			}

            //$customizer = $wpdb->get_results("SELECT * FROM wp_customizers WHERE id = $customizer_id", OBJECT);
			$customizer	= cus_get_customizer_data($customizer_id);
            if (!empty($customizer)) {
				include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/steps.php';
            } else {
                esc_html_e('This Product have not any customizer to display.', 'tailors-online');
            }
        }

    }

    /**
     * Create The Object Of Current Class
     */
    new WpCustomizer_Public_Hooks();
}