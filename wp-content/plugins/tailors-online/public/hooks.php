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
 
 if( !class_exists( 'TailorsOnline_Public_Hooks' ) ) {
 	class TailorsOnline_Public_Hooks {
		public function __construct() {
			//Update cart
			add_action( 'wp_ajax_customizer_update_cart', array( &$this, 'customizer_update_cart' ) );
    		add_action( 'wp_ajax_nopriv_customizer_update_cart' , array( &$this, 'customizer_update_cart'));
			
			//Update measurements
			add_action( 'wp_ajax_customizer_update_measurements', array( &$this, 'customizer_update_measurements_in_session' ) );
    		add_action( 'wp_ajax_nopriv_customizer_update_measurements' , array( &$this, 'customizer_update_measurements_in_session'));
			
			//Update apparel settings
			add_action( 'wp_ajax_customizer_update_settings', array( &$this, 'customizer_update_settings_in_session' ) );
    		add_action( 'wp_ajax_nopriv_customizer_update_settings' , array( &$this, 'customizer_update_settings_in_session'));

			//Checkout hook to print order
			add_action( 'customizer_loop_item_cart_info', array( &$this, 'customizer_loop_item_cart_info') );
			
			//get customizer id
			add_filter( 'cu_get_customizer_by_product', array( &$this, 'cus_get_customizer_by_product') );
			
			//Add class for current theme
			add_filter( 'body_class', array( &$this, 'cus_body_classes' ) );
			
		}
		
		/**
		 * Update cart
		 */
		public function customizer_update_cart() {
			global $woocommerce,$sitepress;
			$do_check = check_ajax_referer( 'customizer_request', 'customizer_request', false );
			if( $do_check == false ){
				$json['type']	= 'error';
				$json['message']	= esc_html__('No kiddies please!','tailors-online');	
				echo json_encode($json);
				die;
			}

			if( empty( $_POST['customizer']['product_id'] ) || empty( $_POST['customizer']['customizer_id'] ) ) {
				$json['type']	= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','tailors-online');	
				echo json_encode($json);
				die;
			}
			
			$product_id = absint( $_POST['customizer']['product_id'] );
			$cart		= !empty( $_POST['customizer'] ) ? $_POST['customizer'] : '';
			
			TailorsOnline_Public_Hooks::update_cart( $cart,'general',$product_id ); //Update cart

			$cart_data = array(
				'product_id'    => $product_id,
				'cart_data'     => $cart,
			);
		
			if ( class_exists( 'WooCommerce' ) ) {
				$cart_item_data = $cart_data;
				
				$c_product = wc_get_product( $product_id );
				$variation		= '';
				$variation_data	= array();
				
				if( $c_product->is_type( 'variable' ) ) {
					$variation			= !empty( $_COOKIE['variation_id'] ) ?  $_COOKIE['variation_id'] : null;
					if( !empty( $variation ) ){
						$_product 			= new WC_Product_Variation( $variation );
						$variation_data 	= $_product->get_variation_attributes();
					}
				}

				WC()->cart->add_to_cart( $product_id, 1, $variation, $variation_data, $cart_item_data );
				
				$json['type']		= 'success';
				$json['message']	 = esc_html__('You cart has updated. Your are moving to cart page.','tailors-online');
				
				
				if( !empty( $_POST['customizer']['wpml_lang'] ) ){
					$json['cart_url']	= esc_url( $sitepress->convert_url( $woocommerce->cart->get_cart_url(), $_POST['customizer']['wpml_lang'] ));
				} else{
					$json['cart_url']	= esc_url( $woocommerce->cart->get_cart_url());
				}
				
				echo json_encode($json);
				die;
				
			} else{
				$json['type']	= 'error';
				$json['message']	= esc_html__('Please install woocommerce plugin','tailors-online');	
				echo json_encode($json);
				die;
			}
		
		}
		
		/**
		 * Update cart in session
		 */
		public function customizer_update_measurements_in_session() {
			global $woocommerce;
			$cart_key	= 'cart_data';
			$cart_index	= !empty( $_POST['current_index'] ) ? $_POST['current_index'] : '';
			
			$do_check = check_ajax_referer( 'measurements_request', 'measurements_request', false );
			
			if( $do_check == false ){
				$json['type']	= 'error';
				$json['message']	= esc_html__('No kiddies please!','tailors-online');	
				echo json_encode($json);
				die;
			}
			
			//Get cart session data
			$data = (array)WC()->session->get( 'cart',null );
			
			if( empty( $data[$cart_index]['product_id'] ) 
			   || 
			   empty( $data[$cart_index]['cart_data']['customizer_id'] ) 
			 ) {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','tailors-online');	
				echo json_encode($json);
				die;
			}

			if ( empty( $data[$cart_index][$cart_key] ) ) {
				$data[$cart_index][$cart_key] = array();
			}
			
			$measurements_data	= !empty( $_POST['measurements'][$cart_index]['sizes'] ) ? $_POST['measurements'][$cart_index]['sizes'] : array();
			$data[$cart_index][$cart_key]['measurements'] = $measurements_data;
			
			//Update cart measurements
			WC()->session->set( 'cart', $data );
			
			$cart	= $data;
			$product_id = absint( $_POST[$cart_index]['product_id'] );
			
			TailorsOnline_Public_Hooks::update_cart( $cart,'measurements',$product_id ); //Update cart
			
			
			$json['type']		= 'success';
			$json['message']	= esc_html__('Measurements updated successfully','tailors-online');
			$json['checkout_url']	= esc_url( $woocommerce->cart->get_checkout_url() );
			echo json_encode($json);
			die;

		}
		
		/**
		 * Update Apparels in session
		 */
		public function customizer_update_settings_in_session() {
			global $woocommerce;
			$cart_key	= 'cart_data';
			$cart_index	= !empty( $_POST['current_index'] ) ? $_POST['current_index'] : '';
			
			$do_check = check_ajax_referer( 'customizer_request', 'customizer_request', false );
			
			if( $do_check == false ){
				$json['type']	= 'error';
				$json['message']	= esc_html__('No kiddies please!','tailors-online');	
				echo json_encode($json);
				die;
			}
			
			
			//Get cart session data
			$data = (array)WC()->session->get( 'cart',null );

			if( empty( $data[$cart_index]['product_id'] ) 
			   || 
			   empty( $data[$cart_index]['cart_data']['customizer_id'] ) 
			 ) {
				$json['type']		= 'error';
				$json['message']	= esc_html__('Some error occur, please try again later','tailors-online');	
				echo json_encode($json);
				die;
			}

			if ( empty( $data[$cart_index][$cart_key] ) ) {
				$data[$cart_index][$cart_key] = array();
			}
			
			$apparel_style   = !empty( $_POST['customizer'][$cart_index]['style'] ) ? $_POST['customizer'][$cart_index]['style'] : array();
			$apparel_data	= !empty( $_POST['customizer'][$cart_index]['apparels'] ) ? $_POST['customizer'][$cart_index]['apparels'] : array();
			
			$data[$cart_index][$cart_key]['style'] 	= $apparel_style;
			$data[$cart_index][$cart_key]['apparels'] = $apparel_data;

			//Update cart apparels settings
			WC()->session->set( 'cart', $data );
			
			$cart	= $data;
			$product_id = absint( $_POST[$cart_index]['product_id'] );
			
			TailorsOnline_Public_Hooks::update_cart( $cart,'general',$product_id ); //Update cart
			
			
			$json['type']			= 'success';
			$json['message']		 = esc_html__('Settings updated successfully','tailors-online');
			$json['checkout_url']	= esc_url( $woocommerce->cart->get_checkout_url() );
			echo json_encode($json);
			die;

		}
		
		/**
		 * Update cart in session
		 */
		public function customizer_loop_item_cart_info() {
			global $product,$woocommerce;
			$cart_data = WC()->session->get( 'cart', null );

			include TailorsOnlineGlobalSettings::get_plugin_path().'/templates/checkout/item_cart_info.php';
		}
		
		
		/**
		 * Get cart.
		 *
		 * @return array
		 * @since 2.0
		 */
		public static function get_cart() {
			$cart = isset( $_SESSION['customizer_cart'] ) && is_array( $_SESSION['customizer_cart'] ) ? $_SESSION['customizer_cart'] : array();
			return $cart;
		}
	
	
		/**
		 * Update cart.
		 *
		 * @param  array $data New cart data.
		 * @since 2.0
		 */
		public static function update_cart( $data,$type='general',$product_id='' ) {
			$_SESSION['customizer_cart'][$type][$product_id][] = $data;
		}
	
	
		/**
		 * Delete cart.
		 *
		 * @since 2.0
		 */
		public static function delete_cart() {
			global $woocommerce;
			$_SESSION['customizer_cart'] = array();
	
			if ( class_exists( 'WooCommerce' ) ) {
				WC()->cart->empty_cart();
			}
		}
		
		/**
		 * Remove product from cart.
		 *
		 * @return void
		 * @since 2.0
		 */
		public function remove_product_from_cart() {
			if ( ! isset( $_POST['product_id'] ) ) {
				die();
			}
	
			$this->remove_data_from_cart( absint( $_POST['product_id'] ) );
			die();
		}
		
		/**
		 * Remove product data from cart.
		 *
		 */
		public static function remove_data_from_cart( $product_id ) {
			$cart = $this->get_cart();
	
			if ( ! isset( $cart[ $product_id ] ) ) {
				return;
			}
	
			unset( $cart[ $product_id ] );
	
			$this->update_cart( $cart );
	
			// var_dump($cart);
	
			if ( class_exists( 'WooCommerce' ) ) {
				$cart = WC()->cart->get_cart();
				foreach ( $cart as $cart_key => $cart_item ) {
					if ( $product_id == $cart_item['product_id'] ) {
						WC()->cart->remove_cart_item( $cart_key );
					}
				}
			}
		}
		
		/**
		 * get woo session data
		 *
		 */
		public function cus_woo_get_item_data( $cart_item_key, $key = null, $default = null ) {
			global $woocommerce;
			
			$data = (array)WC()->session->get( 'cart',$cart_item_key );
			if ( empty( $data[$cart_item_key] ) ) {
				$data[$cart_item_key] = array();
			}
			
			// If no key specified, return an array of all results.
			if ( $key == null ) {
				return $data[$cart_item_key] ? $data[$cart_item_key] : $default;
			}else{
				return empty( $data[$cart_item_key][$key] ) ? $default : $data[$cart_item_key][$key];
			}
		}
		
		/**
		 * Update woo session data
		 *
		 */
		public function cus_woo_set_item_data( $cart_item_key, $key, $value ) {
			global $woocommerce;
			
			$data = (array)WC()->session->get( 'cus_woo_product_data' );
			
			if ( empty( $data[$cart_item_key] ) ) {
				$data[$cart_item_key] = array();
			}
			
			$data[$cart_item_key][$key] = $value;
			
			WC()->session->set( 'cus_woo_product_data', $data );
		}
		
		/**
		 * Remove woo session data.
		 *
		 */
		public function cus_woo_remove_item_data( $cart_item_key = null, $key = null ) {
			global $woocommerce;
			
			$data = (array)WC()->session->get( 'cus_woo_product_data' );
			
			// If no item is specified, delete *all* item data. This happens when we clear the cart (eg, completed checkout)
			if ( $cart_item_key == null ) {
				WC()->session->set( 'cus_woo_product_data', array() );
				return;
			}
			
			// If item is specified, but no data exists, just return
			if ( !isset( $data[$cart_item_key] ) ) {
				return;
			}
			if ( $key == null ) {
				// No key specified, delete this item data entirely
				unset( $data[$cart_item_key] );
			}else{
				if ( isset( $data[$cart_item_key][$key] ) ) {
					unset( $data[$cart_item_key][$key] );
				}
			}
			
			WC()->session->set( 'cus_woo_product_data', $data );
		}
		
		/**
		 * @init            Render customzer in product
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            Register Input Fields Settings
		 */
		public function cus_get_customizer_by_product($product_id= '') {
			global $woocommerce;
			
			if( empty($product_id) ){
				return;
			}
			
			$id	= get_post_meta($product_id, 'customizer_linked_id',true); //exit;
			
			return $id;
		}
		
		/**
		 * @init            Add theme class to body
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            Register Input Fields Settings
		 */
		public function cus_body_classes($classes) {
			$theme_version = wp_get_theme();
			$current_theme	= $theme_version->get( 'TextDomain' );
			$classes[] = 'customizer-'.$current_theme;
			
			if ( is_user_logged_in() ) {
				$classes[] = 'customizer-loggedin';
			}
			
			if ( get_option('enable_wp_customizer') == 'yes' ) {
				if ( get_option('enable_cartbtn_detail') === 'yes' ) {
					if ( class_exists('WooCommerce') ) {
						if( is_product() ){
							$classes[] = 'customizer-hide-cartbtn';
						}
					}
				}
			}
			
			return $classes;
		}
		
	}
	
	new TailorsOnline_Public_Hooks();
 }


/**
 * @Dukan Compatibility
 * @return 
 */
if (!function_exists('dokan_new_product_after_product_tags')) {
	//add_action( 'dokan_product_edit_after_product_tags','dokan_edit_product_add_fields',10,2 );
	add_action( 'dokan_new_product_after_product_tags','dokan_customizer_add_fields');
	function dokan_edit_product_add_fields($post,$post_id){
		global $wpdb;
		ob_start();
		$posts_array = array();
		$args        = array(
			'posts_per_page'      => "-1" ,
			'post_type'           => 'wp_customizer' ,
			'order'               => 'DESC' ,
			'orderby'             => 'ID' ,
			'post_status'         => 'publish' ,
			'ignore_sticky_posts' => 1
		);

		$posts_query = get_posts($args);

		$current	= '';
		if( isset( $post_id ) ){
			$current	= get_post_meta($post_id, 'customizer_linked_id',true); //exit;
		}
		?>
		<div class="cus-select dokan-comp dokan-form-group">
			<label for="product_tag" class="form-label"><?php esc_html_e("Select Customizer","tailors-online");?></label>
			<select name="customizer_linked_id">
				<option value=""><?php esc_html_e("Select Customizer","tailors-online");?></option>
				<?php 
				if( !empty( $posts_query ) ){
					foreach ($posts_query as $item){
						$selected	= '';
						if( !empty( $current ) && intval( $item->ID ) === intval( $current ) ){
							$selected	= 'selected';
						}
						?>
							<option <?php echo esc_attr( $selected );?> value="<?php echo intval( $item->ID );?>"><?php echo esc_attr( $item->post_title );?></option>
						<?php
					}
				}
				?>
			</select>
		</div>

		<?php
		echo ob_get_clean();
	}
	
	//Edit product
	function dokan_customizer_add_fields(){
		global $wpdb;
		ob_start();
		$posts_array = array();
		$args        = array(
			'posts_per_page'      => "-1" ,
			'post_type'           => 'wp_customizer' ,
			'order'               => 'DESC' ,
			'orderby'             => 'ID' ,
			'post_status'         => 'publish' ,
			'ignore_sticky_posts' => 1
		);

		$posts_query = get_posts($args);
		?>
		<div class="cus-select dokan-comp dokan-form-group">
			<select name="customizer_linked_id">
				<option value=""><?php esc_html_e("Select Customizer","tailors-online");?></option>
				<?php 
				if( !empty( $posts_query ) ){
					foreach ($posts_query as $item){
						?>
							<option value="<?php echo intval( $item->ID );?>"><?php echo esc_attr( $item->post_title );?></option>
						<?php
					}
				}
				?>
			</select>
		</div>

		<?php
		echo ob_get_clean();
	}
	
	
}

/**
 * @Dukan Compatibility update and add new fields
 * @return 
 */
if (!function_exists('dokan_comaptibility_product_updated')) {
	add_action( 'dokan_product_updated','dokan_comaptibility_product_updated',10,2 );
	add_action( 'dokan_new_product_added','dokan_comaptibility_product_updated',10,2 );
	function dokan_comaptibility_product_updated( $product_id, $data ){
		if( isset( $data['customizer_linked_id'] ) ){
			update_post_meta($product_id, 'customizer_linked_id',$data['customizer_linked_id']); //exit;
		}
	}
}