<!--Underscore Templates-->
<script type="text/template" id="tmpl-load-apparel-tab">
	<div class="apparel-counter" data-apparel_number="{{data.apparel}}">
	  <div class="action-wrap">
		<div class="tg-icons cus-apparel-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
		<div class="tg-icons actio-mode cus-actions-item  tg-accordion"> <i class="icon-pencil"></i> </div>
	  </div>
	  <h4 class="apparel-control"><span><?php esc_html_e('Apparel','tailors-online');?>&nbsp;{{data.apparel}}</span></h4>
	  <div class="apperel-main-wrapper tg-inner">
		<div class="apparel-content-wrap">
		  <div class="apparel-front-back">
			<div class="tg-inputfield tg-inputfull">
			  <input type="text" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][title]" placeholder="<?php esc_html_e('Add apparel title','tailors-online');?>">
			</div>
			<div class="tg-mediafilestitle"><?php esc_html_e('Apparel front/back images','tailors-online');?></div>
			  <div class="apparel_assets_container tg-mediafiles tg-scrollbar">
				<div class="apparel_front tg-displaybox">
				  <div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
					  <figure class="apparel_front_wrap"> <i class="tg-deleteicon fa fa-trash-o delete_apparel_front_logo"></i> <img width="171" src="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" data-placeholder="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" id="apparel_front_image">
						<input type="hidden" name="customizer[apparel][{{data.apparel}}][apparel_front_id]" id="apparel_front_img_id" value="">
						<input type="hidden" name="customizer[apparel][{{data.apparel}}][apparel_front_url]" id="apparel_front_img_url" value="">
					  </figure>
					  <div class="tg-radioandtitle"><strong><?php esc_html_e('Apparel front image','tailors-online');?></strong></div>
				   </div>
				   <div class="tg-fileupload">
						<div class="tg-dragfiles">
						  <label for="file" class="apparel_front_img" data-apperal_no="{{data.apparel}}" data-step_number="1"> <span class="tg-uploadtitle">
							<?php esc_html_e('Apparel front image.', 'tailors-online'); ?>
							</span> <span class="tg-browse">
								<?php esc_html_e('Select File', 'tailors-online'); ?>
							</span> 
						   </label>
						</div>
					</div>
				</div>

				<div class="apparel_back tg-displaybox">
					<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
						<figure class="apparel_back_wrap"> <i class="tg-deleteicon fa fa-trash-o delete_apparel_back_logo"></i> <img width="171" src="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" data-placeholder="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" id="apparel_back_image">
						  <input type="hidden" name="customizer[apparel][{{data.apparel}}][apparel_back_id]" id="apparel_back_img_id" value="">
						  <input type="hidden" name="customizer[apparel][{{data.apparel}}][apparel_back_url]" id="apparel_back_img_url" value="">
						</figure>
						<div class="tg-radioandtitle"><strong><?php esc_html_e('Apparel back image','tailors-online');?></strong></div>
					</div>
					<div class="tg-fileupload">
						<div class="tg-dragfiles">
						  <label for="file" class="apparel_back_img" data-apperal_no="{{data.apparel}}" data-step_number="1"> <span class="tg-uploadtitle">
							<?php esc_html_e('Apparel back image.', 'tailors-online'); ?>
							</span> <span class="tg-browse">
							<?php esc_html_e('Select File', 'tailors-online'); ?>
							</span> 
						  </label>
						</div>
					</div>
				</div>
			  </div>
		  </div>
		  <div class="apparel-steps-main">
			<div class="tg-mediafilestitle"><?php esc_html_e('Apparel Steps','tailors-online');?></div>
			<div class="steps-main-wrap">
			<div class="step-counter" data-step_number="1">
			  <div class="action-wrap">
			  	<div class="tg-icons cus-step-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
			  	<div class="tg-icons actio-mode cus-actions-item  tg-accordion"> <i class="icon-pencil"></i> </div>
				<div class="tg-icons cus-actions-item"> <i class="icon-move"></i> </div>
			  </div>
			  <h4 class="steps-control"><span><?php esc_html_e('Step','tailors-online');?>&nbsp;1</span></h4>
			  <div class="customizer-step-data tg-inner">
			   <div class="tg-displaybox">
				  <div class="tg-radioandtitle"> 
					<span class="tg-radio">
						<input type="radio" id="is_front_{{data.apparel}}_{{data.step}}" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][step_location]" value="is_front">
					<label for="is_front_{{data.apparel}}_{{data.step}}"></label>
					</span> 
					<span class="step_location_label"><?php esc_html_e('IS FRONT?','tailors-online');?></span>
				   </div>
				</div>
				<div class="tg-displaybox">
				  <div class="tg-radioandtitle"> 
					<span class="tg-radio">
						<input type="radio" id="is_back_{{data.apparel}}_{{data.step}}" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][step_location]" value="is_back">
					<label for="is_back_{{data.apparel}}_{{data.step}}"></label>
					</span> <span class="step_location_label"><?php esc_html_e('IS BACK?','tailors-online');?></span> 
				  </div>
				</div>
				<div class="tg-inputfield tg-inputfull">
				  <input type="text" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][title]" placeholder="<?php esc_html_e('Add title','tailors-online');?>">
				</div>
				<div class="tg-plceholder">
				  <textarea name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][description]"></textarea>
				</div>
				<div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets','tailors-online');?></div>
				<div class="tg-mediafilesanduploader">
				  <div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
					<div class="assets_container"></div>
				  </div>
				  <div class="tg-fileupload">
					<div class="tg-dragfiles">
					  <label for="file" class="add_step_asset" data-apperal_no="{{data.apparel}}" data-step_number="1"> <span class="tg-uploadtitle"><?php esc_html_e('Add step assets','tailors-online');?></span> <span class="tg-browse"><?php esc_html_e('Select Files','tailors-online');?></span> </label>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		   </div>
		   <a class="tg-btn add_new_customizer_tab" id="add_new_customizer_tab" href="javascript:;"><?php esc_html_e('Add More Steps','tailors-online');?></a> </div>
		</div>
	  </div>
	</div>
</script>

<script type="text/template" id="tmpl-load-customizer-tab">
	<div class="step-counter" data-step_number="{{data.step}}">
		<div class="action-wrap">
			<div class="tg-icons cus-step-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
			<div class="tg-icons actio-mode cus-actions-item tg-accordion"> <i class="icon-pencil"></i> </div>
			<div class="tg-icons cus-actions-item"> <i class="icon-move"></i> </div>
		</div>
		<h4>
			<span><?php esc_html_e('Step','tailors-online');?> {{data.step}}</span>
		</h4>
		<div class="customizer-step-data tg-inner">
			<div class="tg-displaybox">
			  <div class="tg-radioandtitle"> 
				<span class="tg-radio">
					<input type="radio" id="is_front_{{data.apparel}}_{{data.step}}" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][step_location]" value="is_front">
				<label for="is_front_{{data.apparel}}_{{data.step}}"></label>
				</span> 
				<span class="step_location_label"><?php esc_html_e('IS FRONT?','tailors-online');?></span>
			   </div>
			</div>
			<div class="tg-displaybox">
			  <div class="tg-radioandtitle"> 
				<span class="tg-radio">
					<input type="radio" id="is_back_{{data.apparel}}_{{data.step}}" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][step_location]" value="is_back">
				<label for="is_back_{{data.apparel}}_{{data.step}}"></label>
				</span> <span class="step_location_label"><?php esc_html_e('IS BACK?','tailors-online');?></span> 
			  </div>
		  </div>
			<div class="tg-inputfield tg-inputfull">
				<input type="text" class="tg-formcontrol" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][title]" placeholder="<?php esc_html_e('Add title','tailors-online');?>">
			</div>
			<div class="tg-plceholder">
				<textarea placeholder="<?php esc_html_e('Please add description','tailors-online');?>" name="customizer[apparel][{{data.apparel}}][steps][{{data.step}}][description]"></textarea>
			</div>	
			<div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets','tailors-online');?></div>
			<div class="tg-mediafilesanduploader">
				<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
					<div class="assets_container"></div>
				</div>
				<div class="tg-fileupload">
					<div class="tg-dragfiles">
						<label for="file" class="add_step_asset" data-apperal_no="{{data.apparel}" data-step_number="{{data.step}}">
							<span class="tg-uploadtitle"><?php esc_html_e('Add step assets','tailors-online');?></span>
							<span class="tg-browse"><?php esc_html_e('Select Files','tailors-online');?></span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>


<script type="text/template" id="tmpl-load-assets">
	<div class="tg-displaybox">
		<i class="tg-deleteicon delete_asset fa fa-trash-o"></i>
		<i class="upload_asset fa fa-upload"></i>
		<div class="customizer_assets_img _screenshot">
			<figure><img width="171" height="171" src="<?php echo plugins_url('images/large.jpg', dirname(__FILE__)); ?>" alt="<?php esc_html_e('style','tailors-online');?>"></figure>
		</div>
		<div class="tg-radioandtitle">

			<span class="tg-radio">
				<input type="radio" id="default-{{data.id}}{{step_number}}" name="customizer[steps][{{step_number}}][assets][default]" value="{{data.asset_counter}}">
				<label for="default-{{data.id}}{{step_number}}" title="<?php esc_html_e('Set as Default','tailors-online');?>"></label>
			</span>
			<input type="text" name="customizer[steps][{{step_number}}][assets][data][{{data.asset_counter}}][image_title]" class="tg-formcontrol media_default" placeholder="<?php esc_html_e('Add title','tailors-online');?>">

			<input type="hidden" class="media_id" name="customizer[steps][{{step_number}}][assets][data][{{data.asset_counter}}][media_id]" value="{{data.id}}">
			<input type="hidden" class="media_url" name="customizer[steps][{{step_number}}][assets][data][{{data.asset_counter}}][media_url]" value="{{data.url}}">
		</div>
	</div>
</script>
<script type="text/template" id="tmpl-load-step-data">
	<div class="step-asset-main">
		<div class="action-wrap">
			<div class="tg-icons cus-asset-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
			<div class="tg-icons actio-mode cus-actions-item tg-accordion"> <i class="icon-pencil"></i> </div>
			<div class="tg-icons cus-actions-item"> <i class="icon-move"></i> </div>
		</div>
		<h4><span><?php esc_html_e('Assets','tailors-online');?></span></h4>
		<div class="customizer-step-data tg-inner">
			<div class="tg-displaybox is_default_step">
				<span class="tg-radio">
					<input type="radio" id="default-step-{{data.step_number}}" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][default]" value="{{data.asset_counter}}">
					<label for="default-step-{{data.step_number}}" title="<?php esc_html_e('Set as default','tailors-online');?>"></label>
					<span class="step_location_label"><?php esc_html_e('Set as default','tailors-online');?></span>
				</span>
			</div>
			<div class="tg-inputfield tg-inputfull">
				<input type="text" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][title]" class="tg-formcontrol media_default" placeholder="<?php esc_html_e('Add title','tailors-online');?>">
			</div>
			<div class="tg-plceholder">
				<textarea placeholder="<?php esc_html_e('Short description','tailors-online');?>" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][description]"></textarea>
			</div>
			<div class="tg-displaybox">
				<i data-key="icon" class="upload_step_asset fa fa-upload"></i>
				<div class="customizer_assets_img _screenshot">
					<figure><img width="171" height="171" src="<?php echo plugins_url('images/small.jpg', dirname(__FILE__)); ?>" alt="<?php esc_html_e('style','tailors-online');?>"></figure>
					<input type="hidden" class="media_id" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][media_icon_id]" value="{{data.icon_id}}">
					<input type="hidden" class="media_url" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][media_icon_url]" value="{{data.icon_url}}">
				</div>

			</div>
			<div class="tg-displaybox">
				<i data-key="large" class="upload_step_asset fa fa-upload"></i>
				<div class="customizer_assets_img _screenshot">
					<figure><img width="171" height="171" src="<?php echo plugins_url('images/large.jpg', dirname(__FILE__)); ?>" alt="<?php esc_html_e('style','tailors-online');?>"></figure>
					<input type="hidden" class="media_id" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][media_large_id]" value="{{data.large_id}}">
					<input type="hidden" class="media_url" name="customizer[apparel][{{data.apparel_number}}][steps][{{data.step_number}}][assets][data][{{data.asset_counter}}][media_large_url]" value="{{data.large_url}}">
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-load-styles-assets">
	<div class="tg-displaybox style-{{data}}">
		<i class="tg-deleteicon delete_asset fa fa-trash-o"></i>
		<i class="upload_asset fa fa-upload"></i>
		<div class="styles_assets_img _screenshot">
			<figure><img width="171" height="171" src="<?php echo plugins_url('images/large.jpg', dirname(__FILE__)); ?>" alt="<?php esc_html_e('style','tailors-online');?>"></figure>
		</div>
		<div class="tg-radioandtitle">
			<span class="tg-radio">
				<input type="radio" id="default-styles-{{data}}" name="styles[assets][default]" value="{{data}}">
				<label for="default-styles-{{data}}" title="<?php esc_html_e('Set as Default','tailors-online');?>"></label>
			</span>
			<input type="text" name="styles[assets][data][{{data}}][image_title]" class="tg-formcontrol media_default" placeholder="<?php esc_html_e('Add title','tailors-online');?>">
			<input type="hidden" class="media_id" name="styles[assets][data][{{data}}][media_id]" value="">
			<input type="hidden" class="media_url" name="styles[assets][data][{{data}}][media_url]" value="">
		</div>
	</div>
 </script>