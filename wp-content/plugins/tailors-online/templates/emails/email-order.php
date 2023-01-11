<?php
/**
 * The template for email when order place
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */

if( !empty( $items ) ) {
	$counter	= 0;
	foreach( $items as $key => $order_item ){
		$counter++;
		$item_id    = $order_item['product_id'];
		$name		= !empty( $order_item['name'] ) ?  $order_item['name'] : '';
		$quantity	= !empty( $order_item['qty'] ) ?  $order_item['qty'] : 1;
		$order_detail = wc_get_order_item_meta( $key, 'cus_woo_product_data', true );
		?>
		<table class="cus-table" style="background:#fbfbfb; margin:auto 0; width:600px; border-spacing:0; border-radius: 3px;">
			<tbody>
				<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
					<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5; font-size: 20px; font-weight: bold;"><?php echo esc_attr($name);?><span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span></td>
				</tr>
				<?php
				$style	= !empty( $order_detail['style'] ) ? $order_detail['style'] : array();
				$apparels	= !empty( $order_detail['apparels'] ) ? $order_detail['apparels'] : array();
				$measurements	= !empty( $order_detail['measurements'] ) ? $order_detail['measurements'] : array();

				if( !empty( $style ) ) {	
					?>
					<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
						<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><strong><?php echo esc_html__('Style','tailors-online');?></strong></td>
					</tr>
					<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
						<td scope="col" style="text-align:left; padding:0 0; border:0; border-bottom:1px solid #ececec; line-height: 2.5;">
							<table style="width:100%; margin:0; border-spacing:0;">
								<tbody>
									<tr style="line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
										<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; border-right:1px solid #ececec; line-height: 2.5;"><?php esc_html__('Your Style','tailors-online');?></td>
										<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><?php echo esc_attr($style);?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				<?php }

				//apparels
				if( !empty( $apparels ) ) {
					foreach ($apparels as $key => $apparel) {
						$apparel_key	=  !empty( $apparel['title'] ) ? cus_prepare_title_to_name($apparel['title']) : '';
				?>
				<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
					<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><strong><?php echo esc_attr( ucwords( $apparel['title'] ) );?></strong></td>
				</tr>
				<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
					<td scope="col" style="text-align:left; padding:0 0; border:0; border-bottom:1px solid #ececec; line-height: 2.5;">
						<table style="width:100%; margin:0; border-spacing:0;">
							<tbody>
								<?php 
								if( !empty( $apparel['data'] ) ) {
								  foreach ($apparel['data'] as $key => $step) {
									$step_key 	=  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
									?>
									<tr style="line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
										<td scope="col" style="width:50%; text-align:left; border:0; border-bottom:1px solid #ececec; border-right:1px solid #ececec; line-height: 2.5; padding:0 15px;"><?php echo esc_attr( $step['label'] );?></td>
										<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><?php echo esc_attr( $step['value'] );?></td>
									</tr>
									<?php }?>
								<?php }?>
							</tbody>
						</table>
					</td>
				</tr>
				<?php }
				}

				//measurements
				if( !empty( $measurements )) {
				?>
					<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
						<td scope="col" style="text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><strong><?php esc_html_e('Measurements?','tailors-online');?></strong></td>
					</tr>
					<tr style="text-align:left; border:0; line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
						<td scope="col" style="text-align:left; padding:0 0; border:0; border-bottom:1px solid #ececec; line-height: 2.5;">
							<table style="width:100%; margin:0; border-spacing:0;">
								<tbody>
									<?php
										foreach ($measurements as $key => $measurement) {
											$measurement_type	=  !empty( $apparel['type'] ) ? $apparel['type'] : '';
											$type	= esc_html__('Inches','tailors-online');
											if( $measurement_type === 'cm' ){
												$type	= esc_html__('Centimeter','tailors-online');
											}
										 ?>
										<tr style="line-height: 2.5; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;">
											<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; border-right:1px solid #ececec; line-height: 2.5;"><?php echo esc_attr( $measurement['label'] );?></td>
											<td scope="col" style="width:50%; text-align:left; padding:0 15px; border:0; border-bottom:1px solid #ececec; line-height: 2.5;"><?php echo esc_attr( $measurement['value'] );?>&nbsp;<?php echo esc_attr( $type );?></td>
										</tr>
										<?php }?>
								</tbody>
							</table>
						</td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	<?php }?>
<?php }