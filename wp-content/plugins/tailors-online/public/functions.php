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
 * @access          public
 * @init            get name
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            get class name from title
 */
if( !function_exists('cus_prepare_title_to_name') ) {
	function cus_prepare_title_to_name($title='') {
		return strtolower(sanitize_html_class($title));
	}
}

/**
 * @access          public
 * @init            get steps
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            get customizer steps data 
 */
if( !function_exists('cus_get_customizer_data') ) {
	function cus_get_customizer_data($post_id='') {
		if( empty($post_id) ){
			return;
		}
		
		$styles	= get_post_meta($post_id,'_customizer_style',true);
		$steps	= get_post_meta($post_id,'_customizer_steps',true);
		
		$styles	=  !empty($styles) ? $styles : array();
		$steps	=  !empty($steps) ? $steps : array();
		
		return array_merge($styles,$steps);
	}
}

/**
 * @access          public
 * @init            get type
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            get measurement type inches/centimeter
 */
if( !function_exists('cus_get_measurement_type') ) {
	function cus_get_measurement_type($size='') {
		if( isset( $size ) && $size === 'cm' ) {
		  $type	= esc_html__('Centimeter','tailors-online');
		} else{
		   $type	= esc_html__('Inches','tailors-online');
		}
		return $type;
	}
}

/**
 * @access          public
 * @init            get measurement 
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            get measurement extras by id
 */
if( !function_exists('cus_get_measurements_extras') ) {
	function cus_get_measurements_extras($term_id='') {
		return get_term_meta( $term_id, 'measurement_settings', true );
	}
}

/**
 * @access          public
 * @init            get measurement 
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            get measurement extras by id
 */
if( !function_exists('cus_get_measurements_data') ) {
	function cus_get_measurements_data($customizer_id='') {
		$measurements = get_the_terms($customizer_id,'measurements');
		
		return $measurements;
	}
}
/**
 * @access          public
 * @init            Remove parent from measurements
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            Remove parent from measurements
 */
if ( ! function_exists( 'cus_remove_parent_from_category' ) ) {
	add_action( 'admin_head-edit-tags.php', 'cus_remove_parent_from_category' );
	add_action( 'admin_head-term.php', 'cus_remove_parent_from_category' );
	function cus_remove_parent_from_category(){
		if ( 'measurements' != $_GET['taxonomy'] ) {
			return;
		}
	
		$parent = 'parent()';
	
		if ( isset( $_GET['tag_ID'] ) && !empty( $_GET['tag_ID'] ) )
			$parent = 'parent().parent()';
	
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('label[for=parent]').<?php echo ( $parent ); ?>.remove();       
			});
		</script>
		<?php
	}
}

/**
 * @access          public
 * @init            Remove category review link
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            Remove category review link
 */
if ( ! function_exists( 'cus_remove_view_link_category' ) ) {
	add_filter( 'measurements_row_actions', 'cus_remove_view_link_category',10,2 );
	function cus_remove_view_link_category($actions, $tag) {
		unset($actions['view']);
 		return $actions;
	}
}

/**
 * @access          public
 * @init            Remove category review link
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/hooks
 * @since           1.0
 * @desc            Remove category review link
 */
if ( ! function_exists( 'cus_get_dynamic_style' ) ) {
	function cus_get_dynamic_style() {
		$color_code	= get_option('wp_customizer_color');
		$custom_css	= get_option('wp_customizer_css');
        $color_code	=  !empty( $color_code ) ? $color_code : '#57c778';
		ob_start();
		if( !empty( $color_code ) ){
			?>

			.cus-btn,
			.tg-steps ul li.tg-active a,
			.tg-customizeordernav li.cus-active a,
			.tg-btnround:hover,
			.tg-btnround:hover,
			.tg-suitstyle label:hover span,
			.tg-suitstyle input[type="radio"]:checked + label span,
			.success,
			#confirmBox h1,
			#confirmBox .tailor-button:before,
			.cus-modal-header,
			.cus-btn.update_settings,
			.customizer-loader > div,
			input[type="submit"].cus-btn, 
			.cus-btn,
			input[type="submit"].cus-btn:hover, 
			.cus-btn:hover,
			.tg-btn:before,
			.measurement-update-btn input[type="submit"].cus-btn
			{background:<?php echo esc_attr($color_code);?>}


			.tg-customcontent .tg-radio label:hover figure,
			.tg-suitstyle label:hover span:before, 
			.tg-suitstyle input[type="radio"]:checked + label span:before, 
			.tg-customcontent .tg-radio:hover label figure:before, 
			.tg-customcontent .tg-radio input[type="radio"]:checked + label figure:before,
			.tg-customizeordernav li.cus-active a:before,
			.tg-customizeordernav li.cus-active a:after,
			.tg-btnround:hover, .tg-btnround:hover,
			.tg-customcontent .tg-radio input[type=radio]:checked + label figure, 
			.tg-customcontent .tg-radio label:hover figure,
			#confirmBox .tailor-button
			{border-color:<?php echo esc_attr($color_code);?>}

			.tg-btn
			{border-color:<?php echo esc_attr($color_code);?> !important}

			.tg-suitstyle label:hover span:before, 
			.tg-suitstyle input[type="radio"]:checked + label span:before, 
			.tg-customcontent .tg-radio:hover label figure:before, 
			.tg-customcontent .tg-radio input[type="radio"]:checked + label figure:before,
			.tg-customizeordernav li a span:before,
			.tg-steps ul li a:after
			{color:<?php echo esc_attr($color_code);?>}

			.input[type="submit"].cus-btn:hover, 
			.cus-btn:hover{background: rgba(29, 33, 30, 0.79);}

		<?php
		}
		//Custom css
		if( !empty( $custom_css ) ){
			echo esc_attr( $custom_css );
		}
		
		$styles	= ob_get_clean();
 		return $styles;
	}
}

