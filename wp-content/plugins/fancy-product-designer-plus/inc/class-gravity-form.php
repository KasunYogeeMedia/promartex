<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(!class_exists('FPD_Plus_Gravity_Form')) {

	class FPD_Plus_Gravity_Form {

		private $show_order_viewer = false;

		public function __construct() {

			//FRONTEND

			add_shortcode( 'fpd_gf', array( &$this, 'gf_shortcode') );
			add_action( 'gform_entry_created', array( &$this, 'gf_entry_crated'), 10, 2 );


			//BACKEND

			// Entry Detail
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_styles_scripts' ) );
			add_filter( 'gform_field_content', array(&$this, 'gf_hide_fpd_order'), 10, 3 );
			add_action( 'gform_entry_detail', array(&$this, 'gf_add_order_viewer'), 10, 2 );
			add_action( 'wp_ajax_fpd_gf_get_order_data', array( &$this, 'ajax_get_order_data' ) );

		}

		public function gf_shortcode( ) {

			wp_enqueue_script( 'gform_gravityforms' );

			ob_start();
			echo  do_shortcode( '[fpd]' );
			?>
			<style type="text/css">
				.fpd-gf-price + input {
					display: none !important;
				}
			</style>
			<script type="text/javascript">

				jQuery(document).ready(function() {

					var $gfForm = jQuery('.gfield.fpd-order').parents('form:first');

					if($gfForm.length > 0) {

						$gfForm.on('click', 'input:submit', function(evt) {

							evt.preventDefault();

							if(!fpdProductCreated) { return false; }

							var order = fancyProductDesigner.getOrder({
									customizationRequired: <?php echo fpd_get_option('fpd_customization_required') == 'none' ? 0 : 1; ?>
								});

							if(order.product != false) {

								<?php do_action( 'fpd_plus_gf_js_order_data' ); ?>

								$gfForm.find('.fpd-order input').val(JSON.stringify(order));
								$gfForm.submit();

							}

						});

					}

					$selector.on('priceChange', function() {

						var currency = new Currency(gf_global.gf_currency_config),
							totalPrice = fancyProductDesigner.calculatePrice(),
							$priceInput = $gfForm.find('.fpd-price input');

						$priceInput.val(currency.toMoney(totalPrice, true));

						if($priceInput.prev('.fpd-gf-price').length > 0) {
							$priceInput.prev('.fpd-gf-price').html(currency.toMoney(totalPrice, true));
						}
						else {
							$priceInput.before('<p class="fpd-gf-price">'+currency.toMoney(totalPrice, true)+'</p>');
						}

					});


				});

			</script>
			<?php
			$output = ob_get_contents();
			ob_end_clean();

			return $output;

		}

		public function gf_entry_crated( $entry, $form ) {

			foreach($form['fields'] as $field) {

				if($field['cssClass'] == 'fpd-order') {

					$fpd_order = json_decode( $field->get_value_export( $entry, $field['id'] ), true );

					$fpd_data = array(
						'fpd_product' => $fpd_order['product'],
						'fpd_print_order' => $fpd_order['print_order']
					);

					$additional_data = array(
						'order_id' => $entry['id'],
					);

					$fpd_data = apply_filters( 'fpd_new_order_item_data', $fpd_data, 'gf', $additional_data );

				}

			}
		}

		public function enqueue_styles_scripts( $hook ) {

			//add necessary styles and scripts into entry detail
			if( isset($_GET['page']) && $_GET['page'] === 'gf_entries' && isset($_GET['view']) ) {

				wp_enqueue_style( 'fpd-react-order-viewer', plugins_url('/admin/react-app/css/gf-order-viewer.css', FPD_PLUGIN_ADMIN_DIR), array(
					'fpd-semantic-ui',
					'jquery-fpd'
				), Fancy_Product_Designer::VERSION );

				wp_enqueue_script( 'fpd-react-order-viewer', plugins_url('/admin/react-app/js/gf-order-viewer.js', FPD_PLUGIN_ADMIN_DIR), array(
					'fpd-semantic-ui',
					'fpd-admin',
					'jquery-fpd',
				), Fancy_Product_Designer::VERSION);

			}

		}

		public function gf_hide_fpd_order( $content, $field, $value ) {

			//hide fpd-order row and create JS variable with fpd order data
			if( isset($_GET['page']) && $_GET['page'] == 'gf_entries' && strpos($field->cssClass, 'fpd-order') !== false && !empty($value) ) {
				$content = '<tr class="fpd-hidden"><td><script>var fpdGfFormId = '.$field->formId.'; var fpdGfFieldId = '.$field->id.'; var fpdGfLeadId = '.$_GET['lid'].';</script></td></tr>';
				$this->show_order_viewer = true;
			}

			return $content;

		}

		public function gf_add_order_viewer( $form, $lead ) {

			if( $this->show_order_viewer ):
			?>
			<div class="ui segment">
				<div id="fpd-react-root"></div>
			</div>
			<?php
			endif;

		}

		public function ajax_get_order_data() {

			check_ajax_referer( 'fpd_ajax_nonce' );

			$lead = RGFormsModel::get_lead($_POST['leadId']);
			$field = GFAPI::get_field( $_POST['formId'], $_POST['fieldId'] );
			$value = RGFormsModel::get_lead_field_value( $lead, $field );

			header('Content-Type: application/json');
			echo json_encode($value);

			die;
		}

	}

}

new FPD_Plus_Gravity_Form();

?>