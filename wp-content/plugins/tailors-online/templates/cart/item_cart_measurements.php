<?php
/**
 * The template for displaying item measurements
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
 
ob_start();
if( !empty( $measurements ) ) {
?>
	<div class="tg-formcustomorder wp-measurement-form">
	  <div class="custom-measurement-data <?php echo esc_attr( $measurement_type );?>">
		  <?php 
		  $counter	= 0;
		  $total_measurements	= !empty( $measurements ) ? count($measurements) : '';
		  foreach( $measurements as $key => $measurement ) {
			  $extras = cus_get_measurements_extras($measurement->term_id);
			  $counter++;
			  $title	= !empty( $measurement->name ) ? $measurement->name : '';
			  $description	= !empty( $measurement->description ) ? $measurement->description : '';

			  if( isset( $extras['parameter_size'] ) && $extras['parameter_size'] === 'cm' ) {
				  $placeholder	= esc_html__('Add size here (centimeter)','tailors-online');
				  $size	= 'cm'; 
			  } else{
				   $placeholder	= esc_html__('Add size here (inches)','tailors-online');
				   $size	= 'in'; 
			  }

			  $is_active	= $counter === 1 ? 'tg-current' : '';
			  $first_measurement	= $counter === 1 ? 'tg-disabled' : '';
			  $last_item	= $counter === $total_measurements ? 'show-measurement-btn' : '';
			  $last_measurement	= $counter === $total_measurements ? 'tg-disabled' : '';
			  $title_key	= cus_prepare_title_to_name($title);
			  
			  $db_value	= '';
			  if( !empty( $cart_item['cart_data']['measurements'][$title_key]['value'] ) ){
				 $db_value	= $cart_item['cart_data']['measurements'][$title_key]['value'];
			  }

			  $default = !empty( $extras['assets']['default'] ) ? $extras['assets']['default'] : 1;
			?>
			  <div class="measurement-parent <?php echo esc_attr($is_active);?> <?php echo esc_attr($last_item);?>">
				<div class="tg-measurementcontent">
					<div class="cus-col-5">
						<div class="tg-neckcontent">
							<?php if( !empty( $extras['assets']['data'] ) ) {?>
								<figure class="tg-sizeimg">
									<?php if( !empty( $extras['assets']['data'][$default]['media_url'] ) ) {?>
										<div class="measurement-tumbnails first-thumb"><img src="<?php echo esc_url( $extras['assets']['data'][$default]['media_url'] );?>" alt="<?php echo esc_attr( $extras['assets']['data'][$default]['image_title'] );?>"></div>
									<?php }?>
									<?php
										foreach( $extras['assets']['data'] as $key => $image ){
											if( !empty( $image['media_url'] ) ) {
										?>
											<div class="measurement-tumbnails"><img src="<?php echo esc_url( $image['media_url'] );?>" alt="<?php echo esc_attr( $image['image_title'] );?>"></div>
									<?php }}?>
								</figure>
							<?php }?>
						</div>
					</div>
					<div class="cus-col-7">
						<?php if( !empty( $title ) ) {?>
							<h2><?php echo esc_attr( $title );?></h2>
						<?php }?>
						<?php if( !empty( $description ) ) {?>
							<div class="tg-description">
								<?php echo wpautop( $description );?>
							</div>
						<?php }?>
					  <div class="measurement-fieldbox">
						<input type="text" name="measurements[<?php echo esc_attr($cart_item_key);?>][sizes][<?php echo esc_attr($title_key);?>][value]" class="form-control measurement_val" placeholder="<?php echo esc_attr($placeholder);?>" value="<?php echo esc_attr( $db_value );?>">
						<input type="hidden" name="measurements[<?php echo esc_attr($cart_item_key);?>][sizes][<?php echo esc_attr($title_key);?>][label]" class="form-control" value="<?php echo esc_attr($title);?>">
						<input type="hidden" name="measurements[<?php echo esc_attr($cart_item_key);?>][sizes][<?php echo esc_attr($title_key);?>][key]" class="form-control" value="<?php echo esc_attr($measurement->term_id);?>">
						<input type="hidden" name="measurements[<?php echo esc_attr($cart_item_key);?>][sizes][<?php echo esc_attr($title_key);?>][type]" class="form-control" value="<?php echo esc_attr($size);?>">
					  </div>
					  <div class="measurements-button-wrap">
						<a href="javascript:;" class="cus-btn measurement-steps  measurement-prev tg-btnprevious <?php echo esc_attr($first_measurement);?>"><?php echo esc_html__('Previous','tailors-online');?></a> 
						<a href="javascript:;" class="cus-btn measurement-steps measurement-next tg-btnnext <?php echo esc_attr($last_measurement);?>"><?php echo esc_html__('Next','tailors-online');?></a>
					  </div>
					  <?php if( !empty( $extras['parameter_video']  ) ) {?>
					  <div class="tg-videobox"> 
						<?php
							$video_url	= $extras['parameter_video'];
							$url = parse_url( $video_url );
							$height = 255;
							$width  = 485;
							if ($url['host'] == $_SERVER["SERVER_NAME"]) {
								echo '<figure class="tg-classimg">';
								echo do_shortcode('[video width="' . $width . '" height="' . $height . '" src="' . $video_url . '"][/video]');
								echo '</figure>';
							} else {
								if ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com') {
									echo '<figure class="tg-classimg">';
									$content_exp  = explode("/" , $video_url);
									$content_vimo = array_pop($content_exp);
									echo '<iframe width="' . $width . '" height="' . $height . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
							></iframe>';
									echo '</figure>';
								} elseif ($url['host'] == 'soundcloud.com') {
									$height = 205;
									$width  = 485;
									$video  = wp_oembed_get($video_url , array (
										'height' => $height ));
									$search = array (
										'webkitallowfullscreen' ,
										'mozallowfullscreen' ,
										'frameborder="0"' );
									echo '<figure class="tg-classimg">';
									echo str_replace($search , '' , $video);
									echo '</figure>';
								} else {
									echo '<figure class="tg-classimg">';
									$content = str_replace(array (
										'watch?v=' ,
										'http://www.dailymotion.com/' ) , array (
										'embed/' ,
										'//www.dailymotion.com/embed/' ) , $video_url);
									echo '<iframe width="' . $width . '" height="' . $height . '" src="' . $content . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
									echo '</figure>';
								}
							}
						?>
					  </div>
					  <?php }?>
					</div>
				</div>
				<div class="counter-number">
					<span><?php echo esc_attr( $counter.'/'.$total_measurements);?></span>
				</div>
			  </div>
		  <?php }?>
	  </div>
	  <div class="measurement_type">
	  	<div class="measurement-update-btn">
	  		<input type="submit" data-type="save_only" class="cus-btn save_and_checkout" value="<?php esc_html_e('Save Settings','tailors-online');?>">
	  		<input type="submit" data-type="save_close" class="cus-btn save_and_checkout " value="<?php esc_html_e('Save & Close','tailors-online');?>">
	  	</div>
	  </div>
	  <div class="measurement-checkout">
		<input type="hidden" name="measurements[<?php echo esc_attr($cart_item_key);?>][product_id]" value="<?php echo intval($product_id);?>" />
		<input type="hidden" name="measurements[<?php echo esc_attr($cart_item_key);?>][customizer_id]" value="<?php echo intval($customizer_id);?>" />
		<input type="hidden" class="current_cart" name="measurements[cart_index]" value="<?php echo esc_attr($cart_item_key);?>" />
		<?php wp_nonce_field('measurements_request', 'measurements_request'); ?>
	  </div>
	</div>
<?php
}
echo ob_get_clean();