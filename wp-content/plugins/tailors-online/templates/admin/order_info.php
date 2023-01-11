<?php
/**
 * The template for displaying admin order detail
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
if( !empty( $order_detail ) ) {?>
	<div class="order-edit-wrap">
		<div class="view-order-detail">
			<a href="javascript:;" data-target="#cus-order-modal-<?php echo esc_attr( $item_id );?>" class="cus-open-modal cus-btn cus-btn-sm"><?php esc_html_e('View order detail?','tailors-online');?></a>
		</div>
		<div class="cus-modal" id="cus-order-modal-<?php echo esc_attr( $item_id );?>">
			<div class="cus-modal-dialog">
				<div class="cus-modal-content">
					<div class="cus-modal-header">
						<a href="javascript:;" data-target="#cus-order-modal-<?php echo esc_attr( $item_id );?>" class="cus-close-modal">×</a>
						<h4 class="cus-modal-title"><?php esc_html_e('Customize Order Detail','tailors-online');?></h4>
					</div>
					<div class="cus-modal-body">
						<div class="cus-form cus-form-change-settings">
							<div class="admin-order-detail-wrap">
							<?php 
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
										$measurement_type	=  !empty( $measurement['type'] ) ? $measurement['type'] : '';
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
										<span><?php esc_html__('Standard','tailors-online');?></span>
									</div>
								</div>
							</div>
							<?php }?>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>
<?php						
}