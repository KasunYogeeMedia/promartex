<?php 
/**
 * @Dukan Compatibility
 * @return 
 */
if (!function_exists('dokan_new_product_after_product_tags')) {
	add_action( 'dokan_new_product_after_product_tags','dokan_new_product_add_fields' );
	function dokan_new_product_add_fields(){
		global $wpdb;
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
		if( isset( $object->ID ) ){
			$current	= get_post_meta($object->ID, 'customizer_linked_id',true); //exit;
		}
		?>
		<div class="cus-select">
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