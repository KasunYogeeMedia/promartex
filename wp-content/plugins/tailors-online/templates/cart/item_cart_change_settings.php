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
if( !empty( $styles_assets['data'] ) ) {?>
<div class="cus-formroup">
	<div class="edit-type-wrap">
		<div class="cus-options-type"><span><?php esc_html_e('Style?','tailors-online');?></span></div>
		<div class="cus-options-data">
			<label><?php esc_html_e('Select style','tailors-online');?></label>
			<div class="cus-select">
				<select name="customizer[<?php echo esc_attr($cart_item_key);?>][style]">
					<?php 
						foreach( $styles_assets['data'] as $key => $value ){
							$customizer_style	= !empty( $value['image_title'] ) ? cus_prepare_title_to_name( $value['image_title'] ) : '';
							$session_value	= !empty( $cart_item['cart_data']['style'] ) ? cus_prepare_title_to_name( $cart_item['cart_data']['style'] ) : '';
							$selected = '';
							if( !empty( $session_value ) && $session_value === $customizer_style ){
								$selected	= 'selected';
							}
					?>
						<option <?php echo esc_attr( $selected );?> value="<?php echo esc_attr( $customizer_style );?>"><?php echo esc_attr( $value['image_title'] );?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>
<?php }?>
<?php 
	if( !empty( $apparels ) ) {
		foreach ($apparels as $key => $apparel) {
			$apparel_key	=  !empty( $apparel['title'] ) ? cus_prepare_title_to_name($apparel['title']) : '';
		?>
		<div class="edit-type-wrap">
			<div class="cus-options-type">
				<span><?php echo esc_attr( ucwords( $apparel['title'] ) );?></span>
				<input type="hidden" name="customizer[<?php echo esc_attr($cart_item_key);?>][apparels][<?php echo esc_attr($apparel_key);?>][title]" value="<?php echo esc_attr( $apparel['title'] );?>">
			</div>
			<?php 
			if( !empty( $apparel['steps'] ) ) {
			  foreach ($apparel['steps'] as $key => $step) {
				$is_front	= !empty( $step['step_location'] ) ? $step['step_location'] : 'is_front';
				$step_key 	=  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
			?>
			<div class="cus-options-data">
				<label>
					<?php echo esc_attr( $step['title'] );?>
					 <input type="hidden" name="customizer[<?php echo esc_attr($cart_item_key);?>][apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][label]" value="<?php echo esc_attr( $step['title'] );?>">
				</label>
				<div class="cus-select">
					<select name="customizer[<?php echo esc_attr($cart_item_key);?>][apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][value]">
						<?php 
						if( !empty( $step['assets']['data'] ) ) {	  
						  $assets_counter	 = 0;
						  foreach ($step['assets']['data'] as $key => $asset) {
							 $assets_counter++;
							 $is_selected	= '';
							 $asset_key =  !empty( $asset['title'] ) ? cus_prepare_title_to_name($asset['title']) : rand(1,99999);
							 $session_value	= !empty( $cart_item['cart_data']['apparels'][$apparel_key]['data'][$step_key]['value'] ) ? cus_prepare_title_to_name( $cart_item['cart_data']['apparels'][$apparel_key]['data'][$step_key]['value'] ) : '';
							 if( !empty( $session_value ) && $session_value === $asset_key ){
								$is_selected	= 'selected=selected';
							 }
							 
						  ?>
							<option <?php echo esc_attr( $is_selected );?> id="tg-<?php echo esc_attr( $asset['media_icon_id'] );?>" value="<?php echo esc_attr( $asset['title'] );?>"><?php echo esc_attr( $asset['title'] );?></option>
						<?php }}?>
					</select>
				</div>
			</div>
			<?php }?>
			<?php }?>
		</div>
		<?php }?>
<?php }?>
<div class="measurement-update-btn">
	<input type="hidden" name="customizer[<?php echo esc_attr($cart_item_key);?>][product_id]" value="<?php echo intval($product_id);?>" />
	<input type="hidden" name="customizer[<?php echo esc_attr($cart_item_key);?>][customizer_id]" value="<?php echo intval($customizer_id);?>" />
	<input type="hidden" class="current_cart"  name="customizer[cart_index]" value="<?php echo esc_attr($cart_item_key);?>" />
	<?php wp_nonce_field('customizer_request', 'customizer_request'); ?>
	<input type="submit" data-type="save_only" class="cus-btn update_settings" value="<?php esc_html_e('Save Settings','tailors-online');?>">
	<input type="submit" data-type="save_close" class="cus-btn update_settings" value="<?php esc_html_e('Save & Close','tailors-online');?>">
</div>
<?php
echo ob_get_clean();