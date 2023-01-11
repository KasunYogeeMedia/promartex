<?php
if (!class_exists('Customizer_WooCommerce_Hooks')) {

    class Customizer_WooCommerce_Hooks extends TailorsOnline_Public_Hooks {

        /**
         * @access          public
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Construct All hooks and run them in object creation.
         */
        public function __construct() {
           add_action('woocommerce_before_add_to_cart_button', array(&$this, 'cus_add_customizer_button_on_detail_page'), 10); //at detail page
		   add_filter( 'woocommerce_checkout_after_customer_details', array( &$this, 'cus_add_new_fields_checkout' ), 10, 1 );
		   add_filter( 'woocommerce_cart_item_name', array( &$this, 'cus_cart_item_name' ), 10, 3 );
		   add_action( 'woocommerce_add_order_item_meta', array( &$this,'cus_woo_convert_item_session_to_order_meta'), 10, 3 ); //Save cart data
		   add_filter( 'woocommerce_after_order_itemmeta', array( &$this,'cus_woo_order_meta'), 10, 3 );
		   
		   // Display order detail
		   add_action( 'woocommerce_thankyou', array( &$this, 'cus_display_order_data' ), 20 ); 
		   add_action( 'woocommerce_view_order', array( &$this, 'cus_display_order_data' ), 20 );
			
		   //Order email
		   add_action( 'woocommerce_email_before_order_table', array( &$this, 'cus_add_order_meta_email'), 10, 2 );
		   
		   //save customizer data on product detail page
		   add_filter('woocommerce_add_cart_item_data',array( &$this,'cus_add_item_data'), 1,2 );
		   
		   //Replace add to cart button
		   add_action( 'woocommerce_loop_add_to_cart_link', array(&$this,'tailors_online_woocommerce_add_to_cart'), 5,2 );	
		   add_action( 'woocommerce_after_add_to_cart_button', array(&$this,'tailors_wc_shop_cart_button'), 20 );
		   //add_action( 'woocommerce_single_product_summary', array(&$this,'tailors_replace_single_add_to_cart_button' ), 1 );
        }
		
		/**
		 * @Replace add to cart on detail page
		 * @return {}
		 */
		function tailors_wc_shop_cart_button() {
			global $product;
			
			if ( get_option('enable_wp_customizer') == 'yes' && apply_filters('cu_get_customizer_by_product',$product_id) !='' ) {
				if ( get_option('enable_cartbtn_detail') === 'yes' ) {
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
					add_action( 'woocommerce_single_product_summary', array(&$this,'tailors_wc_shop_cart_button' ), 30 );
				}
			}
			
			$product_id	= $product->get_id();
			if ( get_option('enable_wp_customizer') == 'yes' && apply_filters('cu_get_customizer_by_product',$product_id) !='' ) {
				//Get the customizer ID
				$customizer_id	= apply_filters('cu_get_customizer_by_product',$product_id);

				if( empty( $customizer_id ) ){
					return '';
				}
				
				if ( get_option('wp_customizer_on_detail') === 'yes' ) {
					// do nothing
				} else{
					if( $product->is_type( 'variable' )) {
						echo '<a class="tg-btn item-shop-detail single_add_to_cart_button" href="' . site_url('/') . 'customizer?pid=' . $product_id . '">' . get_option('wp_customizer_text', esc_html__('Customize Now!','tailors-online')) . '</a><input type="hidden" name="variation_id" class="variation_id" value="">';
					} else{
						echo '<a class="tg-btn item-shop-detail" href="' . site_url('/') . 'customizer?pid=' . $product_id . '">' . get_option('wp_customizer_text', esc_html__('Customize Now!','tailors-online')) . '</a>';
					}
					
				}
				
            }
		}

		/**
		 * @Add to cart button
		 * @return {}
		 */
		public function tailors_online_woocommerce_add_to_cart($html, $product){
			global $product;
			$product_id	= $product->get_id();

			if ( get_option('enable_wp_customizer') == 'yes' && apply_filters('cu_get_customizer_by_product',$product_id) !='' ) {
                if ( get_option('enable_cartbtn') === 'yes' ) {
					//Get the customizer ID
					$customizer_id	= apply_filters('cu_get_customizer_by_product',$product_id);
				
					if( empty( $customizer_id ) ){
						return $html;
					}
					
					// WooCommerce compatibility
					if( $product->is_type( 'variable' ) ) {
						//do nothing
					} else{
						$html = '<a class="tg-btn item-shop" href="' . site_url('/') . 'customizer?pid=' . $product_id . '">' . get_option('wp_customizer_text', esc_html__('Customize Now!','tailors-online')) . '</a>';
					}
					
					return $html;
					
				} else{
					return $html;
				}
            } else{
				return $html;
			}
		}
		
		/**
		 * Add customize button on product detail page
		 *
		 * @since 1.0
		*/
        public function cus_add_customizer_button_on_detail_page() {
            global $product,$woocommerce;
			$product_id	= $product->get_id();
			if ( get_option('enable_wp_customizer') == 'yes' && apply_filters('cu_get_customizer_by_product',$product_id) !='' ) {
                if ( get_option('wp_customizer_on_detail') === 'yes' ) {
					
					//Get the customizer ID
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
        }
		
		/**
		 * Save customer data on detail page
		 *
		 * @since 1.0
		*/
		 public function cus_add_item_data($cart_item_data,$product_id){
			/*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
			global $woocommerce;
			$product_id  = absint( $product_id );
			$cart		= !empty( $_POST['customizer'] ) ? $_POST['customizer'] : '';
	
			$cart_data = array(
				'cart_data'     => $cart,
			);
			
			
			 if(empty($cart_item_data)) {
                return $cart_data;
			 } else {
                return array_merge($cart_item_data,$cart_data);
			 }
		
		}
		
		/**
		 * Print  order detail at checkout page
		 *
		 * @since 1.0
		*/
		public function cus_add_new_fields_checkout() {
			global $product,$woocommerce;
		?>
			<div class="apb-room-selected_content">
				<?php do_action( 'customizer_loop_item_cart_info' ); ?>
			</div>
		<?php
		}
		
		
		/**
		 * Customize cart item detail for modifications
		 *
		 * @since 1.0
		*/
		public function cus_cart_item_name($name, $cart_item,$cart_item_key) {
			global $product,$woocommerce,$wpdb;
			$rand_setting_key	= rand(1,99999);
			$rand_measurements_key	= rand(1,99999);
			
			$measurement_type	= 'display-measurement-box';	
			$seleted_measurement	= 'custom';
			
			ob_start();
			?>
			<div class="cart-item-detail">
				<span class="cart-item-name"><?php echo force_balance_tags( $name );?></span>
				<div class="tailor-edit-button">
					<?php
						$customizer_id	= apply_filters('cu_get_customizer_by_product',$cart_item['product_id']);
						if( !empty( $customizer_id ) && !empty( $cart_item['cart_data'] ) ){
							$product_id = $cart_item['product_id'];
							$customizer_id = $cart_item['cart_data']['customizer_id'];
							$customizer	= cus_get_customizer_data($customizer_id);
							$measurements = cus_get_measurements_data($customizer_id);
							$customizer	= (object)$customizer;
							$apparels =  !empty( $customizer->apparel ) ?  $customizer->apparel : array();
							$styles_name = !empty( $customizer->styles_name ) ? $customizer->styles_name : '';
							$styles_description = !empty( $customizer->styles_description ) ? $customizer->styles_description : '';
							$styles_assets = !empty( $customizer->assets ) ? $customizer->assets : array();
							$total_steps	= count($apparels);
						?>
						<div class="cart-edit-wrap">
							<!-- Change settings -->
							<span class="cart-item-modification">
								<a href="javascript:;" data-target="#cus-measurement-modal-<?php echo esc_attr( $rand_setting_key );?>" class="cus-open-modal cus-btn cus-btn-sm"><?php esc_html_e('Change Settings','tailors-online');?></a>
							</span>
							<div class="customizer-items">
								<div class="cus-modal" id="cus-measurement-modal-<?php echo esc_attr( $rand_setting_key );?>">
									<div class="cus-modal-dialog">
										<div class="cus-modal-content">
											<div class="cus-modal-header">
												<a href="javascript:;" data-target="#cus-measurement-modal-<?php echo esc_attr( $rand_setting_key );?>" class="cus-close-modal">×</a>
												<h4 class="cus-modal-title"><?php esc_html_e('Change Your Settings','tailors-online');?></h4>
											</div>
											<div class="cus-modal-body">
												<div class="cus-form cus-form-change-settings">
														<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/cart/item_cart_change_settings.php';?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ( get_option('wp_customizer_enable_measurements') === 'yes' ) {?>
						<!-- Change measurements -->
						<div class="cart-measurements-wrap">
							<span class="cart-item-modification"><a href="javascript:;" data-target="#cus-measurement-modal-<?php echo esc_attr( $rand_measurements_key );?>" class="cus-open-modal cus-btn cus-btn-sm"><?php esc_html_e('Add Measurements','tailors-online');?></a></span>
							<div class="measurements-items">
								<div class="cus-modal" id="cus-measurement-modal-<?php echo esc_attr( $rand_measurements_key );?>">
									<div class="cus-modal-dialog">
										<div class="cus-modal-content">
											<div class="cus-modal-header">
												<a href="javascript:;" data-target="#cus-measurement-modal-<?php echo esc_attr( $rand_measurements_key );?>" class="cus-close-modal">×</a>
												<h4 class="cus-modal-title"><?php esc_html_e('Add your measurements','tailors-online');?></h4>
											</div>
											<div class="cus-modal-body">
												<div class="cus-form cus-add-measurements">
														<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/cart/item_cart_measurements.php';?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php }?>
					<?php }?>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}
		
		/**
		 *Save order meta
		 *
		 * @since 1.0
		*/
		public function cus_woo_convert_item_session_to_order_meta( $item_id, $values, $cart_item_key ) {
			$cart_key	= 'cart_data';
			$cart_item_data = $this->cus_woo_get_item_data( $cart_item_key,$cart_key );
			// Add the array of all meta data to "_ld_woo_product_data". These are hidden, and cannot be seen or changed in the admin.
			if ( !empty( $cart_item_data ) ) {
				wc_add_order_item_meta( $item_id, 'cus_woo_product_data', $cart_item_data );
			}
		}
		
		/**
		 *Print order meta at back-end in order detail page
		 *
		 * @since 1.0
		*/
		public function cus_woo_order_meta( $item_id, $item, $_product ) {
			global $product,$woocommerce,$wpdb;
			$order_detail = wc_get_order_item_meta( $item_id, 'cus_woo_product_data', true );
			include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/admin/order_info.php';
		}
		
		/**
		 *Print order meta in order detail page
		 *
		 * @since 1.0
		*/
		public function cus_display_order_data( $order_id ) {
			global $product,$woocommerce,$wpdb;
			$order = new WC_Order( $order_id );
			$items = $order->get_items();
		?>
		<div class="order-detail-wrap">
			<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/thankyou/order_info.php';?>
		</div>
		<?php
		}
		
		/**
		 *Customize order email
		 *
		 * @since 1.0
		*/
		public function cus_add_order_meta_email( $order, $sent_to_admin ) {
			global $product,$woocommerce,$wpdb;
			$order_id	= $order->id;
			$order = new WC_Order( $order_id );
    		$items = $order->get_items();			
			include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/emails/email-order.php';
		}
		
		/**
		 * Add Steps vefore cart table
		 *
		 * @since 1.0
		*/
		public function cus_add_steps_before_cart() {
		?>
		<div class="tg-column-full">
			<div id="tg-content" class="tg-content">
				<div class="tg-steps">
					<ul>
						<li class="cus-selectfabric cus-done"><a href="javascript:;"><?php esc_html_e('Select Fabric', 'tailors-online'); ?></a></li>
						<li class="cus-garment cus-done"><a href="javascript:;"><?php esc_html_e('Customize Garment', 'tailors-online'); ?></a></li>
						<?php if ( get_option('wp_customizer_enable_measurements') === 'yes' ) {?>
							<li class="cus-measurements tg-active"><a href="javascript:;"><?php esc_html_e('Add Measurements', 'tailors-online'); ?></a></li>
						<?php }?>
						<li class="cus-receiveorder"><a href="javascript:;"><?php esc_html_e('Receive Order', 'tailors-online'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php
		}
		
		/**
		 * Add step before thank you message
		 *
		 * @since 1.0
		*/
		public function cus_add_steps_before_message($thankyoutext, $order) {
		?>
		<div class="tg-column-full">
			<div id="tg-content" class="tg-content">
				<div class="tg-steps">
					<ul>
						<li class="cus-selectfabric cus-done"><a href="javascript:;"><?php esc_html_e('Select Fabric', 'tailors-online'); ?></a></li>
						<li class="cus-garment cus-done"><a href="javascript:;"><?php esc_html_e('Customize Garment', 'tailors-online'); ?></a></li>
						<?php if ( get_option('wp_customizer_enable_measurements') === 'yes' ) {?>
							<li class="cus-measurements cus-done"><a href="javascript:;"><?php esc_html_e('Add Measurements', 'tailors-online'); ?></a></li>
						<?php }?>
						<li class="cus-receiveorder cus-done"><a href="javascript:;"> <?php esc_html_e('Receive Order', 'tailors-online'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="woo-thanks-message">
			<?php echo force_balance_tags($thankyoutext);?>
		</div>
		<?php
		}
	

	}
    /**
     * Create The Object Of Current Class
     */
    new Customizer_WooCommerce_Hooks();
}