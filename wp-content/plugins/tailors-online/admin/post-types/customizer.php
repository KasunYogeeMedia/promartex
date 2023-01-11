<?php
if ( ! defined( 'WPINC' ) ) {
	die('No kiddies please!');
}

/**
 * Customizer post type
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
if (!class_exists('Tailors_Online_Customizer')) {
	class Tailors_Online_Customizer {
		public function __construct() {
			global $pagenow;
			add_action('init', array(&$this, 'init_customizer'));
			add_action('init', array(&$this, 'init_customizer_taxonomies'));
			add_action( 'add_meta_boxes', array(&$this, 'init_customizer_settings' ) );
			add_action( 'admin_menu', array(&$this, 'cus_settings_page') );
			add_action( 'measurements_add_form_fields', array(&$this, 'add_measurement_settings'), 10, 2 );
			add_action( 'created_measurements', array(&$this, 'save_measurement_meta'), 10, 2);
			add_action( 'measurements_edit_form_fields', array(&$this, 'measurement_edit_meta'),10, 2);
			add_action( 'edited_measurements', array(&$this, 'update_measurement_meta'), 10, 2 );
			add_filter('manage_edit-measurements_columns', array(&$this, 'add_measurement_column') );
			add_filter('manage_measurements_custom_column', array(&$this,'add_measurement_column_content'), 10, 3 );
		}
		
		/**
		 * @Init Post Type
		 * @return {post}
		 */
		public function init_customizer() {
			$this->prepare_post_type();
		}
		
		/**
		 * @Prepare Post Type
		 * @return {}
		 */
		public function prepare_post_type() {
			$labels = array(
				'name' =>					esc_html__('Tailors Online', 'tailors-online'),
				'all_items' =>				esc_html__('Customizer', 'tailors-online'),
				'singular_name' =>			esc_html__('Customizer', 'tailors-online'),
				'add_new' =>				esc_html__('Add Customizer', 'tailors-online'),
				'add_new_item' =>			esc_html__('Add New Customizer', 'tailors-online'),
				'edit' =>					esc_html__('Edit', 'tailors-online'),
				'edit_item' =>				esc_html__('Edit Customizer', 'tailors-online'),
				'new_item' =>				esc_html__('New Customizer', 'tailors-online'),
				'view' =>					esc_html__('View Customizer', 'tailors-online'),
				'view_item' =>				esc_html__('View Customizer', 'tailors-online'),
				'search_items' =>			esc_html__('Search Customizer', 'tailors-online'),
				'not_found' =>				esc_html__('No Customizer found', 'tailors-online'),
				'not_found_in_trash' =>		esc_html__('No Customizer found in trash', 'tailors-online'),
				'parent' =>					esc_html__('Parent Customizer', 'tailors-online'),
			);
			$args = array(
				'labels' => $labels,
				'description' =>			esc_html__('This is where you can add new Customizer', 'tailors-online'),
				'public' =>					true,
				'supports' =>				array('title'),
				'show_ui' =>				true,
				'capability_type' =>		'post',
				'map_meta_cap' =>			true,
				'publicly_queryable' =>		true,
				'exclude_from_search' =>	false,
				'hierarchical' =>			false,
				'menu_position' =>			10,
				'rewrite' =>				array('slug' => 'customizer', 'with_front' => true),
				'query_var' =>				false,
				'has_archive' =>			'false',
			);
			register_post_type('wp_customizer', $args);
		}
		
		/**
		 * @Prepare customizer
		 * @return {}
		 */
		public function init_customizer_taxonomies() {
			$labels = array(
				'name' =>					esc_html__('Measurements', 'taxonomy general name', 'tailors-online'),
				'singular_name' =>			esc_html__('Measurements', 'taxonomy singular name', 'tailors-online'),
				'search_items' =>			esc_html__('Search Measurement', 'tailors-online'),
				'all_items' =>				esc_html__('All Measurement', 'tailors-online'),
				'parent_item' =>			esc_html__('Parent Measurement', 'tailors-online'),
				'parent_item_colon' =>		esc_html__('Parent Measurement:', 'tailors-online'),
				'edit_item' =>				esc_html__('Edit Measurement', 'tailors-online'),
				'update_item' =>			esc_html__('Update Measurement', 'tailors-online'),
				'add_new_item' =>			esc_html__('Add New Measurement', 'tailors-online'),
				'new_item_name' =>			esc_html__('New Measurement Name', 'tailors-online'),
				'menu_name' =>				esc_html__('Measurements', 'tailors-online'),
			);
			$args = array(
				'hierarchical' =>			true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
				'labels' =>					$labels,
				'show_ui' =>				true,
				'show_admin_column' =>		true,
				'query_var' =>				true,
				'rewrite' =>				array('slug' => 'measurements'),
			);
			register_taxonomy('measurements', array('wp_customizer'), $args);
		}
		
		/**
		 * @Prepare customizer menu
		 * @return {}
		 */
		public function cus_settings_page() {
			add_submenu_page('edit.php?post_type=wp_customizer', 
				esc_html__('Settings', 'tailors-online'), 
				esc_html__('Settings', 'tailors-online'), 
				'manage_options', 
				'wp-customizer-admin', 
				array(&$this, 'cus_settings_menu')
			);
		}
		
		/**
		 * @access          public
		 * @init            Admin settings page
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/hooks
		 * @since           1.0
		 * @desc            Register The Parent Menu
		 */
		public function cus_settings_menu() {
			do_action('wp_customizer_admin_page');
		}
		
		/**
		 * @Prepare customizer settings
		 * @return {}
		 */
		public function init_customizer_settings() {
			add_meta_box('wp_customizer_settings', 
				esc_html__('Customizer Settings','tailors-online'), 
				array(&$this,'wp_customizer_settings'), 
				'wp_customizer', 
				'normal', 
				'default'
			);
		}
		 /**
		 * @Prepare customizer settings
		 * @return {}
		 */
		public function wp_customizer_settings() {
			if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['post'])) {
				do_action('tailor_edit_customizer');
			} else{
				do_action('tailor_add_new_customizer');
			}
		}
		/**
		 * @measurement settings
		 * @return {}
		 */
		public function add_measurement_settings($taxonomy){
			do_action('tailor_add_new_measurement');
		}
		/**
		 * @measurement Save
		 * @return {}
		 */
		public function save_measurement_meta($term_id, $tt_id){
			$measurements = !empty( $_POST['measurement'] ) ? $_POST['measurement'] : '';
			add_term_meta( $term_id, 'measurement_settings', $measurements, true );
		}
		/**
		 * @measurement update
		 * @return {}
		 */
		public function update_measurement_meta($term_id, $tt_id){
			$measurements = !empty( $_POST['measurement'] ) ? $_POST['measurement'] : '';
			update_term_meta( $term_id, 'measurement_settings', $measurements );
		}		
		/**
		 * @measurement Edit
		 * @return {}
		 */
		public function measurement_edit_meta($term, $taxonomy){
			$measurement_settings = cus_get_measurements_extras($term->term_id);
			do_action('tailor_edit_measurement',$measurement_settings,$term->term_id);
		}
		/**
		 * @measurement Column
		 * @return {}
		 */
		public function add_measurement_column( $columns ){
			unset($columns['posts']);
			$columns['type'] = esc_html__( 'Measurement Type', 'tailors-online' );
			return $columns;
		}
		/**
		 * @measurement Column show
		 * @return {}
		 */
		public function add_measurement_column_content( $content, $column_name, $term_id ){
			if( $column_name !== 'type' ){
				return $content;
			}

			$term_id = absint( $term_id );
			$measurement_settings = get_term_meta( $term_id, 'measurement_settings', true );
			$parameter_size = !empty( $measurement_settings['parameter_size'] ) ? $measurement_settings['parameter_size']  :'';
			$measurement_type 	= cus_get_measurement_type($parameter_size);
			return $measurement_type;
		}
	}
	new Tailors_Online_Customizer();
}