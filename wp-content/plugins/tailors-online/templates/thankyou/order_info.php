<?php
/**
 * The template for displaying loop item for cart
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
if( !empty( $items ) ) {
?>
<div class="cart-data-wrap">
<?php 
	$counter	= 0;
	foreach( $items as $key => $order_item ){
		$counter++;
		$item_id    = $order_item['product_id'];
		$name		= !empty( $order_item['name'] ) ?  $order_item['name'] : '';
		$quantity	= !empty( $order_item['qty'] ) ?  $order_item['qty'] : 5;
		$order_detail = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );
		?>
		<div class="cart-product">
		<h3><?php echo esc_attr($name);?><span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span></h3>
		<?php
			if( !empty( $order_detail ) ) {
				
				$style	= !empty( $order_detail['style'] ) ? $order_detail['style'] : array();
				$apparels	= !empty( $order_detail['apparels'] ) ? $order_detail['apparels'] : array();
				$measurements	= !empty( $order_detail['measurements'] ) ? $order_detail['measurements'] : array();

				//Style
				if( !empty( $style ) ) {
					?>
					<div class="edit-type-wrap">
						<div class="cus-options-type"><span><?php esc_html_e('Style?','tailors-online');?></span></div>
						<div class="cus-options-data">
							<label><span><?php esc_html_e('Your style','tailors-online');?></span></label>
							<div class="step-value">
								<span><?php echo esc_attr( $style );?></span>
							</div>
						</div>
					</div>
					<?php 
				}

				//apparels
				if( !empty( $apparels ) ) {
					foreach ($apparels as $key => $apparel) {
						$apparel_key	=  !empty( $apparel['title'] ) ? cus_prepare_title_to_name($apparel['title']) : '';
					?>
					<div class="edit-type-wrap">
						<div class="cus-options-type">
							<span><?php echo esc_attr( ucwords( $apparel['title'] ) );?></span>
						</div>
						<?php 
						if( !empty( $apparel['data'] ) ) {
						  foreach ($apparel['data'] as $key => $step) {
							$step_key 	=  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
							?>
							<div class="cus-options-data">
								<label><span><?php echo esc_attr( $step['label'] );?></span></label>
								<div class="step-value">
									<span><?php echo esc_attr( $step['value'] );?></span>
								</div>
							</div>
							<?php }?>
						<?php }?>
					</div>
					<?php }
				}

				//measurements
				if( !empty( $measurements ) ) {
					?>
					<div class="edit-type-wrap">
						<div class="cus-options-type"><span><?php esc_html_e('Measurements?','tailors-online');?></span></div>
						<?php
							foreach ($measurements as $key => $measurement) {
								$measurement_type	=  !empty( $apparel['type'] ) ? $apparel['type'] : '';
								$type	= esc_html__('Inches','tailors-online');
								if( $measurement_type === 'cm' ){
									$type	= esc_html__('Centimeter','tailors-online');
								}
						 ?>
							<div class="cus-options-data">
								<label><span><?php echo esc_attr( $measurement['label'] );?></span></label>
								<div class="step-value">
									<span><?php echo esc_attr( $measurement['value'] );?>&nbsp;<?php echo esc_attr( $type );?></span>
								</div>
							</div>
						<?php }?>
					</div>
				<?php
				}else{?>
				<div class="edit-type-wrap">
					<div class="cus-options-type"><span><?php esc_html_e('Measurements?','tailors-online');?></span></div>
					<div class="cus-options-data">
						<label><span><?php esc_html__('Measurement Type','tailors-online');;?></span></label>
						<div class="step-value">
							<span><?php esc_html__('Standard','tailors-online');;?></span>
						</div>
					</div>
				</div>
				<?php }
			}
		?>
	</div>
  <?php }?>
</div>
<?php
}