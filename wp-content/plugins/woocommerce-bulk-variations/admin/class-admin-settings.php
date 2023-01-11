<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( !class_exists('WCBV_Admin_Settings') ) {

	class WCBV_Admin_Settings {

		public function __construct() {

			add_filter( 'woocommerce_settings_tabs_array', array( &$this, 'add_settings_tab' ), 50 );
			add_filter( 'woocommerce_settings_tabs_wcbv', array( &$this, 'settings_output' ) );
			add_action( 'woocommerce_update_options_wcbv', array( &$this, 'update_settings' ) );

		}

		public function add_settings_tab( $tabs ) {

			$tabs['wcbv'] = __('Bulk Variations','radykal');
			return $tabs;

		}

		public function settings_output( $tabs ) {

			woocommerce_admin_fields( $this->get_settings() );

		}

		// add options to the general settings of woocommerce
		public function get_settings() {

			$labels = array(
				array(
					'title'   => __( 'Quantity', 'radykal' ),
					'id'      => 'wcbv_label_quantity',
					'type'    => 'text',
					'default' => 'QTY',
				),
				array(
					'title'   => __( 'Add Variation', 'radykal' ),
					'id'      => 'wcbv_label_add_variation',
					'type'    => 'text',
					'default' => 'Add Variation',
				),
				array(
					'title'   => __( 'Operator', 'radykal' ),
					'id'      => 'wcbv_label_operator',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Operator',
				),
				array(
					'title'   => __( 'Discount', 'radykal' ),
					'id'      => 'wcbv_label_discount',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Discount',
				),
				array(
					'title'   => __( 'Equal', 'radykal' ),
					'id'      => 'wcbv_label_equal',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Equal',
				),
				array(
					'title'   => __( 'Greater than', 'radykal' ),
					'id'      => 'wcbv_label_greater_than',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Greater than',
				),
				array(
					'title'   => __( 'Less than', 'radykal' ),
					'id'      => 'wcbv_label_less_than',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Less than',
				),
				array(
					'title'   => __( 'Greater than or equal', 'radykal' ),
					'id'      => 'wcbv_label_greater_than_equal',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Greater than or equal',
				),
				array(
					'title'   => __( 'Less than or equal', 'radykal' ),
					'id'      => 'wcbv_label_less_than_equal',
					'type'    => 'textarea',
					'css' 		=> 'width:500px;height: 32px;',
					'default' => 'Less than or equal',
				)
			);

			$settings = array(

				array(
		            'name'     => __( 'General', 'radykal' ),
		            'type'     => 'title',
		            'desc'     => '',
		            'id'       => 'wcbv_general_section'
		        ),

				array(
					'title'   => __( 'Button CSS Class', 'radykal' ),
					'desc_tip'    => __( 'So that the buttons are having the same style in your theme, you can set an own CSS class for the buttons.', 'radykal' ),
					'id'      => 'wcbv_button_css_class',
					'type'    => 'text',
					'css' 		=> 'width:500px;',
					'default' => 'wcbv-btn',
				),

				array(
					'title'   => __( 'Include Select2 JS/CSS', 'radykal' ),
					'desc'    => __( 'To avoid conflicts in the frontend, uncheck this option if your theme or another plugin already includes the Select2 library.', 'radykal' ),
					'id'      => 'wcbv_include_select2',
					'default' => 'yes',
					'type'    => 'checkbox',
				),

				array(
		            'type'     => 'sectionend',
		            'id'       => 'wcbv_general_section_end'
		        ),

				array(
		            'name'     => __( 'Labels', 'radykal' ),
		            'type'     => 'title',
		            'desc'     => '',
		            'id'       => 'wcbv_labels_section'
		        ),

			);
			if( defined('ICL_LANGUAGE_CODE') ) {

				//get active languages from WPML
				$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc&skip_missing=0' );

				if (!empty($languages) && sizeof($languages) > 0 ) {

					foreach($labels as $label) {

						$label_id = $label['id'];
						$i=0;

						foreach($languages as $key => $language) {

							if($i > 0)
								$label['title'] = '';

							$label['desc'] = '<i style="font-size: 12px;">'.$languages[$key]['translated_name']. '</i>';
							$label['id'] = $label_id . '_' . $key;
							$settings[] = $label;

							++$i;

						}

					}

				}

			}
			else {

				foreach($labels as $label) {
					$settings[] = $label;
				}

			}
			$settings[] = array( 'type' => 'sectionend', 'id' => 'wcbv_labels_section_end');


			return $settings;

		}

		public function update_settings() {

			woocommerce_update_options( $this->get_settings() );

		}

		// get options for the product meta
		public static function get_product_meta_options() {

			$options = array(

				'position' => array(
					'after_title' => __( 'After Title', 'radykal' ),
					'after_short_desc' => __( 'After Short Description', 'radykal' ),
					'after_product_summary' => __( 'After Product Summary', 'radykal' ),
					'shortcode' => __( 'Via Shortcode: [wcbv]', 'radykal' ),
				),
				'layout' => array(
					'fit_in_row' => __( 'Fit In One Row (Attributes Head)', 'radykal' ),
					'fit_in_row_no_title' => __( 'Fit In One Row (Without Attributes Head)', 'radykal' ),
					'selects_one' => __( 'Selects: One Column', 'radykal' ),
					'selects_two' => __( 'Selects: Two Columns', 'radykal' ),
					'selects_three' => __( 'Selects: Three Columns', 'radykal' ),
					'selects_four' => __( 'Selects: Four Columns', 'radykal' ),
					'selects_five' => __( 'Selects: Five Columns', 'radykal' ),
					'selects_six' => __( 'Selects: Six Columns', 'radykal' ),
				),
				'enable_select2' => 'no',
				'replace_choose_option' => 'no',
				'fixed_amount' => 0,
				'discounts_display' => array(
					'none' => __( 'None', 'radykal' ),
					'before_bulk_variations_form' => __( 'Before Bulk-Variations Form', 'radykal' ),
					'after_bulk_variations_form' => __( 'After Bulk-Variations Form', 'radykal' ),
					'after_short_desc' => __( 'After Short Description', 'radykal' ),
					'after_product_summary' => __( 'After Product Summary', 'radykal' ),
					'shortcode' => __( 'Via Shortcode: [wcbv_discounts]', 'radykal' ),
				),

			);

			if( class_exists('Fancy_Product_Designer') && version_compare(Fancy_Product_Designer::VERSION, '3.0.0', '>=') ) {
				$options['position']['before_fancy_product_designer'] = __( 'Before Fancy Product Designer', 'radykal' );
				$options['position']['after_fancy_product_designer'] = __( 'After Fancy Product Designer', 'radykal' );
			}

			return $options;

		}

	}

}

new WCBV_Admin_Settings();
?>