<?php
/**
 * The template for displaying customizer steps
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
 
$customizer	= (object)$customizer;
$apparels =  !empty( $customizer->apparel ) ?  $customizer->apparel : array();
$styles_name = !empty( $customizer->styles_name ) ? $customizer->styles_name : '';
$styles_description = !empty( $customizer->styles_description ) ? $customizer->styles_description : '';
$styles_assets = !empty( $customizer->assets ) ? $customizer->assets : array();
$total_steps	= count($apparels);
$product_id	= !empty( $_GET['pid'] ) ? $_GET['pid'] : ''; 

ob_start();
?>
<div class="cus-page-wrapper">
<div class="tg-column-full">
	<div id="tg-content" class="tg-content">
		<div class="tg-customizegarments">
			<?php if ( ! is_single() ) {?>
			<form class="tg-formcustomorder wp-customizer-form">
			<?php }?>
				<div class="tg-customordertabs steps-main-wrapper">
					<div id="tg-stickyheader" class="tg-stickyheader steps-next-prev-buttons">
						<?php if( !empty( $apparels ) ) {?>
						<ul class="tg-customizeordernav steps-nav">
							<li class="tg-previous-link"><a href="javascript:;" id="btnMoveLeftTab" class="tg-btnround tg-btnprevious steps-prev"><span class='fa fa-angle-left'><?php esc_html_e('Previous', 'tailors-online'); ?></a></li>
						
							<li class="tab-status cus-active" data-step-count="first-step"><a data-step="step-style" href="#step-style"><span><?php esc_html_e('Style', 'tailors-online'); ?></span></a></li>
							<?php 
								$step_counter	= 0;
								foreach ( $apparels as $key => $apparel ) {
									$step_counter++;
									$is_active	= $key == 1 ? 'cus-active'  :'';
									$step_type	= $total_steps === $step_counter ? 'last-step' : 'step-'.$key;
								?>	
									<li class="tab-status" data-step-count="<?php echo esc_attr( $step_type );?>"><a data-step-count="<?php echo esc_attr( $step_type );?>" data-step="step-<?php echo esc_attr( $key );?>" href="#step-<?php echo esc_attr( $key );?>" ><span><?php echo esc_attr( $apparel['title'] ) ?></span></a></li>
							<?php } ?>
							<li class="tg-next-link"><a href="javascript:;" id="btnMoveRightTab" class="tg-btnround tg-btnnext steps-next"><span class='fa fa-angle-right'></span><?php esc_html_e('Next', 'tailors-online'); ?></a> </li>
							<li class="tg-finish-link tg-hidelink"><a href="javascript:;" id="tg-btnfinish" class="tg-btnround tg-btnnext tg-btnfinish add-to-cart-order"><?php esc_html_e('Finish', 'tailors-online'); ?></span></a></li>
						</ul>
						<?php } else{?>
							<div class="tg-notification-error">
								<p><?php esc_html_e('Ooops! no steps found.','tailors-online');?></p>
							</div>
						<?php }?>
					</div>
					<div class="steps-content-wrap">
						<div id="step-style" class="tg-stepcontent step-active">
							<fieldset class="tg-formstepone tg-fittingstep">
								<?php if( !empty( $styles_name ) || !empty( $styles_description ) ) {?>
								<div class="tg-descriptionbox">
									<?php if( !empty( $styles_name ) ) {?>
										<div class="tg-title">
											<h2><?php echo esc_attr( $styles_name );?></h2>
										</div>
									<?php }?>
									<?php if( !empty( $styles_description ) ) {?>
										<div class="tg-description">
											<p><?php echo esc_attr( $styles_description );?></p>
										</div>
									<?php }?>
								</div>
								<div class="cus-suitstyles">
								<?php }
									if( !empty( $styles_assets['data'] ) ) {
										foreach ($styles_assets['data'] as $key => $style_asset) {
											$radio_counter	= 'radio-'.rand(1,99999);
									?>
										<span class="tg-radio tg-suitstyle tg-suitstyleclassic">
											<input type="radio" id="tg-<?php echo esc_attr( $radio_counter );?>" name="customizer[style]" value="<?php echo esc_attr( $style_asset['image_title']);?>" checked="checked">
											<label for="tg-<?php echo  esc_attr( $radio_counter );?>">
												<span><?php echo  esc_attr( $style_asset['image_title']);?> </span>
												<img src="<?php echo esc_url( $style_asset['media_url']);?>" alt="<?php esc_attr_e('Customizer Style','tailors-online');?>">
											</label>
										</span>
									<?php } } ?>
								</div>
							</fieldset>
						</div>
						<?php 
							if( !empty( $apparels ) ){
								foreach ($apparels as $key => $apparel) {
									$current_id	= $key;
									$apparel_key	=  !empty( $apparel['title'] ) ? cus_prepare_title_to_name($apparel['title']) : '';
								?>
								<div id="step-<?php echo esc_attr($current_id);?>" class="tg-stepcontent">
									<input type="hidden" name="customizer[apparels][<?php echo esc_attr($apparel_key);?>][title]" value="<?php echo esc_attr( $apparel['title'] );?>">
									<!-- Apparel Front Start-->
									<div class="tg-coatfrontbox">
									  <?php if ( !is_single() ) {?>
									  <div class="tg-stickybox cus-col-3">
										<div class="tg-suitviewbox tg-suitfront">
										  <?php if( !empty( $apparel['apparel_front_url'] ) ) {?>
											  <figure class="tg-suitpart tg-suitbg">
												<img src="<?php echo esc_url( $apparel['apparel_front_url'] );?>" >
											  </figure>
										  <?php }?>
										  <?php									
										  if( !empty( $apparel['steps'] ) ) {
											$steps_counter	= 0;
											foreach ( $apparel['steps'] as $key => $step ) {
												$steps_counter++;
												$is_front	= !empty( $step['step_location'] ) ? $step['step_location'] : 'is_front';
												if( $is_front === 'is_front' ) {
													$step_key	=  !empty( $apparel['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
											?>
											  <figure class="tg-suitpart " style="z-index:<?php echo intval( $steps_counter + 1 );?>">
												<img src="<?php  echo  esc_url( $step['assets']['data'][1]['media_large_url']);?>" id="asset-<?php echo esc_attr($step_key) ?>">
											  </figure>
										<?php }} } ?>
										</div>
									  </div>
									  <?php }?>
									  <div class="cus-col-9">
									  <?php 
									  if( !empty( $apparel['steps'] ) ) {
										foreach ($apparel['steps'] as $key => $step) {
											$is_front	= !empty( $step['step_location'] ) ? $step['step_location'] : 'is_front';
											$step_key 	=  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
											if( $is_front === 'is_front' ) {
											?>
											<fieldset class="tg-<?php echo esc_attr($step_key) ?>">
											  <div class="tg-customcontent">
												<div class="tg-lapelscontent">
												  <input type="hidden" name="customizer[apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][label]" value="<?php echo esc_attr( $step['title'] );?>">
												  <?php if( !empty( $step['title'] ) ) {?>
													  <div class="tg-title">
														<h2><?php echo esc_attr( $step['title'] );?></h2>
													  </div>
												  <?php }?>
												  <?php if( !empty( $step['description'] ) ) {?>
													  <div class="tg-description">
														<?php echo wpautop( $step['description']);?></p>
													  </div>
												  <?php }?>
												</div>
												<div class="tg-<?php echo esc_attr($step_key) ?>">
												<?php 
												   if( !empty( $step['assets']['data'] ) ) {	  
													  $assets_counter	 = 0;
													  foreach ($step['assets']['data'] as $key => $asset) {
														 $assets_counter++;
														 $is_checked	= $key == 1 ? 'checked=checked' : '';
														 $asset_key =  !empty( $asset['title'] ) ? cus_prepare_title_to_name($asset['title']) : rand(1,99999);
														 $asset_description =  !empty( $asset['description'] ) ? $asset['description'] : '';
														 $radio_counter	= 'radio-'.rand(1,99999);
														 $media_icon_url 	= !empty( $asset['media_icon_url'] ) ? $asset['media_icon_url'] : '#';
														 $media_large_url 	= !empty( $asset['media_large_url'] ) ? $asset['media_large_url'] : '#';
														  
														 $tooltip	= '';
														 if( !empty( $asset_description ) ){
															 $tooltip	= 'data-balloon-length="medium" data-balloon="'.esc_attr( $asset_description ).'" data-balloon-pos="up"';
														 }
													  ?>
													  <span data-id="<?php echo intval($key);?>" <?php echo ( $tooltip );?> class="medium tg-radio tg-<?php echo esc_attr($asset_key) ?>" data-asset="<?php echo esc_attr($step_key) ?>">
														<input type="radio" <?php echo esc_attr( $is_checked );?> id="tg-<?php echo esc_attr( $radio_counter );?>" name="customizer[apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][value]" value="<?php echo esc_attr( $asset['title'] );?>">
														<label for="tg-<?php echo esc_attr( $radio_counter ); ?>">
														  <figure><img src="<?php echo esc_url( $media_icon_url );?>" data-id="<?php echo intval($key);?>" data-parent="<?php echo esc_url( $media_large_url);?>" alt="<?php echo sanitize_title( $asset['title']);?>"></figure>
														  <span><?php echo esc_attr( $asset['title']);?></span>
														</label>
													  </span>
												<?php }} ?>
												</div>
											  </div>
											</fieldset>
									  <?php }}} ?>
									  </div>
									</div>
									<!-- Apparel Front End-->
									
									<!-- Apparel Back Start-->
									<div class="tg-coatbackbox">
									  <?php if ( !is_single() ) {?>
									  <div class="cus-col-3 tg-stickybox">
										<div class="tg-suitviewbox tg-suitback">
										  <?php if( !empty( $apparel['apparel_back_url'] ) ) {?>
											  <figure class="tg-suitpart tg-suitbg">
												<img src="<?php echo esc_url( $apparel['apparel_back_url'] );?>" >
											  </figure>
										  <?php }?>
										  <?php 
										  if( !empty( $apparel['steps'] ) ) {
											$steps_counter = 0;
											foreach ( $apparel['steps'] as $key => $step ) {
												$steps_counter++;
												$is_back	= !empty( $step['step_location'] ) ? $step['step_location'] : 'is_back';
												if( $is_back === 'is_back' ) {
													$step_key =  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : rand(1,99999);
											?>
											  <figure class="tg-suitpart" style="z-index:<?php echo intval( $steps_counter + 1 );?>">
												<img src="<?php  echo  esc_url( $step['assets']['data'][1]['media_large_url']);?>" id="asset-<?php echo esc_attr($step_key) ?>">
											  </figure>
										<?php }}} ?>
										</div>
									  </div>
									  <?php }?>
									  <div class="cus-col-9">
									  <?php 
									  if( !empty( $apparel['steps'] ) ) {
										foreach ($apparel['steps'] as $key => $step) {
											$is_back	= !empty( $step['step_location'] ) ? $step['step_location'] : 'is_back';
											$step_key =  !empty( $step['title'] ) ? cus_prepare_title_to_name($step['title']) : '';
											if( $is_back === 'is_back' ) {
											?>
											<fieldset class="tg-<?php echo esc_attr($step_key) ?>">
											  <div class="tg-customcontent">
												<div class="tg-lapelscontent">
												  <input type="hidden" name="customizer[apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][label]" value="<?php echo esc_attr( $step['title'] );?>">
												  <?php if( !empty( $step['title'] ) ) {?>
													  <div class="tg-title">
														<h2><?php echo esc_attr( $step['title'] );?></h2>
													  </div>
												  <?php }?>
												  <?php if( !empty( $step['description'] ) ) {?>
													  <div class="tg-description">
														<p><?php echo esc_attr( $step['description'] );?></p>
													  </div>
												  <?php }?>
												</div>
												<div class="tg-<?php echo esc_attr($step_key) ?>">
												<?php 
												   if( !empty( $step['assets']['data'] ) ) {	  
													  $assets_counter	 = 0;
													  foreach ($step['assets']['data'] as $key => $asset) {
														 $assets_counter++;
														 $is_checked	= $assets_counter == 1 ? 'checked=checked' : '';
														 $asset_key =  !empty( $asset['title'] ) ? cus_prepare_title_to_name($asset['title']) : rand(1,99999); 
														 $asset_description =  !empty( $asset['description'] ) ? $asset['description'] : '';
														  
														 $radio_counter	= 'radio-'.rand(1,99999);
														 $media_icon_url 	= !empty( $asset['media_icon_url'] ) ? $asset['media_icon_url'] : '#';
														 $media_large_url 	= !empty( $asset['media_large_url'] ) ? $asset['media_large_url'] : '#';
														 
														 $tooltip	= '';
														 if( !empty( $asset_description ) ){
															 $tooltip	= 'data-balloon-length="medium" data-balloon="'.esc_attr( $asset_description ).'" data-balloon-pos="up"';
														 }
													  ?>
													  <span data-id="<?php echo intval($key);?>" <?php echo ( $tooltip );?> class="medium tg-radio tg-<?php echo esc_attr($asset_key) ?>" data-asset="<?php echo esc_attr($step_key) ?>">
														<input type="radio" <?php echo esc_attr( $is_checked );?> id="tg-<?php echo esc_attr( $radio_counter );?>" name="customizer[apparels][<?php echo esc_attr($apparel_key);?>][data][<?php echo esc_attr($step_key);?>][value]" value="<?php echo esc_attr( $asset['title'] );?>">
														<label for="tg-<?php echo esc_attr( $radio_counter ); ?>">
														  <figure><img src="<?php echo esc_url( $media_icon_url );?>" data-id="<?php echo intval($key);?>" data-parent="<?php echo esc_url( $media_large_url);?>" alt="<?php echo sanitize_title( $asset['title']);?>"></figure>
														  <span><?php echo esc_attr( $asset['title']);?></span>
														</label>
													  </span>
												<?php }} ?>
												</div>
											  </div>
											</fieldset>
										  <?php }}} ?>
									  </div>
									</div>
									<!-- Apparel Back End-->
								  </div>
						<?php }}?>
					</div>
				</div>
				<div class="add-to-cart-order elm-display-none">
					<input type="hidden" name="customizer[product_id]" value="<?php echo intval($product_id);?>" />
					<input type="hidden" name="customizer[customizer_id]" value="<?php echo intval($customizer_id);?>" />
					<?php if ( function_exists('icl_object_id') ) {?>
						<input type="hidden" name="customizer[wpml_lang]" value="<?php echo ICL_LANGUAGE_CODE;?>" />
					<?php }?>
					<?php wp_nonce_field('customizer_request', 'customizer_request'); ?>
				</div>
			<?php if ( ! is_single() ) {?>
				</form>
			<?php }?>
		</div>
	</div>
  </div>
</div>
<?php
echo ob_get_clean();