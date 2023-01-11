<?php
/**
 * Hooks
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */

if (!class_exists('WpCustomizer_Admin_Hooks')) {

    class WpCustomizer_Admin_Hooks {

        /**
         * @access          public
         * @init            Admin Hooks
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Construct All hooks and run them in object creation.
         */
        public function __construct() {
            add_action('wp_customizer_admin_page', array(&$this, 'wp_customizer_admin_page')); //settings page
			add_action('admin_init', array(&$this, 'register_customizer_plugin_settings'));
			add_action("add_meta_boxes", array(&$this, "cus_add_customizer_in_product"));
			add_action('save_post', array(&$this, 'tailer_save_meta_data'));
			
			//Steps
			add_action('tailor_add_new_customizer', array(&$this, 'tailer_add_new_customizer'));
			add_action('tailor_edit_customizer', array(&$this, 'tailor_edit_customizer'));
			
			//Measurements
			add_action('tailor_add_new_measurement', array(&$this, 'tailer_add_new_measurement'));
			add_action('tailor_edit_measurement', array(&$this, 'tailor_edit_measurement'),10,2);
        }
		
        /**
         * @init            Register Settings
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/partials
         * @since           1.0
         * @desc            Register Input Fields Settings
         */
        public function register_customizer_plugin_settings() {
			register_setting('wp-customizer-general-settings-group', 'enable_cartbtn_detail');
			register_setting('wp-customizer-general-settings-group', 'enable_cartbtn');
            register_setting('wp-customizer-general-settings-group', 'enable_wp_customizer');
            register_setting('wp-customizer-general-settings-group', 'wp_customizer_text');
            register_setting('wp-customizer-general-settings-group', 'wp_customizer_enable_measurements');
			register_setting('wp-customizer-general-settings-group', 'wp_customizer_on_detail');
			register_setting('wp-customizer-general-settings-group', 'wp_customizer_color');
			register_setting('wp-customizer-general-settings-group', 'wp_customizer_force');
			register_setting('wp-customizer-general-settings-group', 'wp_customizer_css');
        }
		
		/**
		 * @init            Customizer Admin Page
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            This Function Will Produce All Tabs View.
		 */
		public function wp_customizer_admin_page() {
			$protocol = is_ssl() ? 'https' : 'http';
			ob_start();
		?>
			<div id="tg-main" class="tg-main tg-addnew">
				<div class="wrap">
					<div id="tg-tab1s" class="tg-tabs">
						<ul class="tg-tabsnav">
						   <li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] == 'settings' ? '' : 'tg-active'; ?>">
								<a href="<?php echo cus_prepare_final_url('welcome','wp-customizer-admin'); ?>">
									<?php esc_html_e("What's New?", 'tailors-online'); ?>
								</a>
							</li> 
							<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] == 'settings'? 'tg-active' : ''; ?>">
								<a href="<?php echo cus_prepare_final_url('settings','wp-customizer-admin'); ?>">
									<?php esc_html_e('Settings', 'tailors-online'); ?>
								</a>
							</li>
						</ul>
						<div class="tg-tabscontent">
							<?php
								$customizer_tabs = isset($_GET['tab']) ? $_GET['tab'] : '';
								switch ($customizer_tabs) {
									case "settings":
										tab_general_settings();
										break;
									default:
										tab_system_settings();
										
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}
	
        /**
         * @access          public
         * @init            Admin Parent Menu
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Get All The Woocommerce Categories
         */
        public function get_Customizer_Woo_Categories($woo_cat_id = '') {

            $output = '';
            $args = array(
                'taxonomy' => 'product_cat',
                'orderby' => 'name',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => 1,
                'title_li' => '',
                'hide_empty' => 0
            );
            $all_categories = get_categories($args);

            if (!empty($all_categories) && is_array($all_categories)) {

                $output .='<option value="">'.esc_html__('Select Customizer Category','tailors-online').'</option>';
                foreach ($all_categories as $cat) {
                    $selected = '';
                    if (!empty($woo_cat_id) && $woo_cat_id == $cat->term_id) {
                        $selected = 'selected';
                    }
                    if ($cat->category_parent == 0) {
                        $output .='<option ' . $selected . ' value="' . $cat->term_id . '">' . $cat->name . '</option>';
                    }
                }
                echo force_balance_tags( $output );
            }
        }
		
		/**
         * @access          public
         * @init            Add customizer steps
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Add customizer steps
         */
		public function tailer_add_new_customizer() {
			ob_start();
		?>
		<div class="customizer-editor-wrap">
			<div class="tg-box">
			  <div class="tg-titlebox">
				<h3><?php esc_html_e('Add Styles', 'tailors-online'); ?></h3>
			  </div>
			  <div class="styles_section">
				<div class="tg-group">
				  <div class="styles_data tg-inner">
					<div class="tg-inputfield tg-inputfull">
					  <input type="text" class="tg-formcontrol" value="" name="styles[styles_name]" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
					</div>
					<div class="tg-plceholder">
					  <textarea name="styles[styles_description]" placeholder="<?php esc_html_e('Add description', 'tailors-online'); ?>"></textarea>
					</div>
					<div class="tg-mediafilestitle">
					  <?php esc_html_e('Media Files / Assets', 'tailors-online'); ?>
					</div>
					<div class="tg-mediafilesanduploader">
					  <div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
						<div class="assets_container">
						</div>
					  </div>
					  <div class="tg-fileupload">
						<div class="tg-dragfiles">
						  <label for="file" class="styles_upload"> 
							<span class="tg-uploadtitle">
								<?php esc_html_e('Add step assets', 'tailors-online'); ?>
							</span> 
							<span class="tg-browse">
								<?php esc_html_e('Select Files', 'tailors-online'); ?>
							</span> 
						 </label>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<!--Styles Section End--> 

			<!--Apparel and Steps Code Start-->
			<div class="apparel-and-steps-main-wrap">
			  <div id="apparel-listing" class="apparel-listing">
				<div class="tg-box">
				  <div class="tg-titlebox">
					<h3><?php esc_html_e('Add Apparels', 'tailors-online'); ?></h3>
				  </div>
				  <div class="tg-addcustomizer">
					<div class="customizer_tabs">
					  <div class="tg-group step-parent-wrap">
						<div class="tg-steps">
						  <div class="customizer-apparel-data">
							<div class="apparel-counter" data-apparel_number="1">
							  <div class="action-wrap">
								<div class="tg-icons cus-apparel-action cus-actions-item"> 
									<i class="fa fa-trash-o"></i>
								</div>
								<div class="tg-icons actio-mode cus-actions-item tg-accordion">
									<i class="icon-pencil"></i>
								</div>
							  </div>
							  <h4 class="apparel-control"> 
							  	<span><?php esc_html_e('apparel', 'tailors-online'); ?>&nbsp; 1</span>
							  </h4>
							  <div class="apperel-main-wrapper tg-inner">
								<div class="apparel-content-wrap">
								  <div class="apparel-front-back">
									<div class="tg-inputfield tg-inputfull">
									  <input type="text" class="tg-formcontrol" value="" name="customizer[apparel][1][title]" placeholder="<?php esc_html_e('Add apparel title', 'tailors-online'); ?>">
									</div>
									<div class="tg-mediafilestitle">
									  <?php esc_html_e('Apparel Front/Back images', 'tailors-online'); ?>
									</div>
									  <div class="apparel_assets_container tg-mediafiles tg-scrollbar">
										<div class="apparel_front tg-displaybox">
											<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
											  <figure class="apparel_front_wrap"> 
												<i class="tg-deleteicon delete_asset fa fa-trash-o delete_apparel_front_logo"></i> 
												<img width="171" src="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" data-placeholder="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" id="apparel_front_image">
												<input type="hidden" name="customizer[apparel][1][apparel_front_id]" id="apparel_front_img_id" value="">
												<input type="hidden" name="customizer[apparel][1][apparel_front_url]" id="apparel_front_img_url" value="">
											  </figure>
											  <div class="tg-radioandtitle">
												<strong><?php esc_html_e('Apparel front image', 'tailors-online'); ?></strong>
											  </div>
											</div>
											<div class="tg-fileupload">
												<div class="tg-dragfiles">
												  <label for="file" class="apparel_front_img" data-apperal_no="1" data-step_number="1"> 
													<span class="tg-uploadtitle">
														<?php esc_html_e('Apparel front image.', 'tailors-online'); ?>
													</span> 
													<span class="tg-browse">
														<?php esc_html_e('Select Files', 'tailors-online'); ?>
													</span>
												   </label>
												</div>
											</div>
										</div>	
										<div class="apparel_back tg-displaybox">
											<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
											  <figure class="apparel_back_wrap"> 
												<i class="tg-deleteicon delete_asset fa fa-trash-o delete_apparel_back_logo"></i> 
												<img width="171" src="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" data-placeholder="<?php echo plugins_url('images/apparel_placeholder.png', dirname(__FILE__)); ?>" id="apparel_back_image">
												<input type="hidden" name="customizer[apparel][1][apparel_back_id]" id="apparel_back_img_id" value="">
												<input type="hidden" name="customizer[apparel][1][apparel_back_url]" id="apparel_back_img_url" value="">
											  </figure>
											  <div class="tg-radioandtitle">
												<strong><?php esc_html_e('Apparel back image', 'tailors-online'); ?></strong>
											  </div>
											</div>
											<div class="tg-fileupload">
												<div class="tg-dragfiles">
												  <label for="file" class="apparel_back_img" data-apperal_no="1" data-step_number="1"> <span class="tg-uploadtitle">
													<?php esc_html_e('Apparel back image.', 'tailors-online'); ?>
													</span> <span class="tg-browse">
													<?php esc_html_e('Select Files', 'tailors-online'); ?>
													</span> 
												  </label>
												</div>
											</div>
										</div>
									  </div>
								  </div>
								  <div class="apparel-steps-main">
									<div class="tg-mediafilestitle"><?php esc_html_e('Apparel Steps', 'tailors-online'); ?></div>
									<div class="steps-main-wrap">
									  <div class="step-counter"  data-step_number="1">
									  	<div class="action-wrap">
											<div class="tg-icons cus-step-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
											<div class="tg-icons cus-step-action actio-mode cus-actions-item tg-accordion"> <i class="icon-pencil"></i> </div>
										</div>
										<h4 class="steps-control"> 
											<span><?php esc_html_e('Step', 'tailors-online'); ?> &nbsp;1</span>
										</h4>
										<div class="customizer-step-data tg-inner">
										  <div class="tg-displaybox">
											  <div class="tg-radioandtitle"> 
												<span class="tg-radio">
													<input type="radio" id="is_front_1_1" class="tg-formcontrol" name="customizer[apparel][1][steps][1][step_location]" value="is_front">
												<label for="is_front_1_1"></label>
												</span> 
												<span class="step_location_label"><?php esc_html_e('IS FRONT?', 'tailors-online'); ?></span>
											   </div>
											</div>
											<div class="tg-displaybox">
											  <div class="tg-radioandtitle"> 
												<span class="tg-radio">
													<input type="radio" id="is_back_1_1" class="tg-formcontrol" name="customizer[apparel][1][steps][1][step_location]" value="is_back">
												<label for="is_back_1_1"></label>
												</span> <span class="step_location_label"><?php esc_html_e('IS BACK?', 'tailors-online'); ?></span> 
											  </div>
										  </div>
										  <div class="tg-inputfield tg-inputfull">
											<input type="text" class="tg-formcontrol" value="" name="customizer[apparel][1][steps][1][title]" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
										  </div>
										  <div class="tg-plceholder">
											<textarea placeholder="<?php esc_attr_e('Please add description','tailors-online');?>" name="customizer[apparel][1][steps][1][description]"></textarea>
										  </div>
										  <div class="tg-mediafilestitle">
											<?php esc_html_e('Media Files / Assets', 'tailors-online'); ?>
										  </div>
										  <div class="tg-mediafilesanduploader">
											<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
											  <div class="assets_container"> </div>
											</div>
											<div class="tg-fileupload">
											  <div class="tg-dragfiles">
												<label for="file" class="add_step_asset" data-apperal_no="1" data-step_number="1"> <span class="tg-uploadtitle">
												  <?php esc_html_e('Add step assets', 'tailors-online'); ?>
												  </span> <span class="tg-browse">
												  	<?php esc_html_e('Select Files', 'tailors-online'); ?>
												  </span> </label>
											  </div>
											</div>
										  </div>
										</div>
									  </div>
									</div>
									<a class="tg-btn add_new_customizer_tab" id="add_new_customizer_tab" href="javascript:;">
										<?php esc_html_e('Add More Steps', 'tailors-online'); ?>
									</a> </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
					<input type="hidden" name="customizer_id" value="">
				  </div>
				</div>
				<!--Apparel Button Code Start--> 
				<a class="tg-btn" id="add_new_apparel_tab" href="javascript:;">
					<?php esc_html_e('Add More Apparels', 'tailors-online'); ?>
				</a> 
			  </div>
			</div>
			<!--Apparel and Steps Code End-->
			 
			<!--Apparel and Steps Underscore templates--> 
			<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/admin/customizer-templates/template-customizer.php';?>
			</div>

			<?php
			echo ob_get_clean();
		}

		/**
		 * @access          public
		 * @init            Edit customizer
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/hooks
		 * @since           1.0
		 * @desc            Edit customizer steps
		 */
		public function tailor_edit_customizer($post_id='') {
			ob_start();
			$customizer_id = $_GET['post'];
			$customizer_data = '';
			
			if (!empty($customizer_id)) {
				$customizer_data	= (object)cus_get_customizer_data($customizer_id);
				
				$style_title = !empty($customizer_data->styles_name ) ? $customizer_data->styles_name : '';
				$style_description = !empty($customizer_data->styles_description) ? $customizer_data->styles_description : '';
				$style_assets = !empty($customizer_data->assets ) ? $customizer_data->assets : array();

				?>
				<div class="customizer-editor-wrap">
					<!--Styles Section End-->
					<div class="tg-box">
						<div class="tg-titlebox">
							<h3><?php esc_html_e('Add Styles', 'tailors-online'); ?></h3>
						</div>
						<div class="styles_section">
							<div class="tg-group">
								<div class="styles_data tg-inner">
									<div class="tg-inputfield tg-inputfull">
										<input type="text" class="tg-formcontrol" value="<?php echo esc_attr($style_title); ?>" name="styles[styles_name]" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
									</div>
									<div class="tg-plceholder">
										<textarea name="styles[styles_description]"><?php echo force_balance_tags($style_description); ?></textarea>
									</div>
									<div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets', 'tailors-online'); ?></div>
									<div class="tg-mediafilesanduploader">
										<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
											<div class="assets_container">
												<?php
												if (!empty($style_assets)) {
													
													$check_default = isset($style_assets['default']) ? $style_assets['default'] : '';
													if (!empty($style_assets['data'])) {
														$assets_count	= 0;
														foreach ($style_assets['data'] as $key => $value) {
															$asset_image = !empty($value['media_url']) ? $value['media_url'] : '';
															$asset_image_id = !empty($value['media_id']) ? $value['media_id'] : '';
															$asset_title = !empty($value['image_title']) ? $value['image_title'] : '';
															
															$preview_image	= !empty( $asset_image ) ? $asset_image : plugins_url('images/large.jpg', dirname(__FILE__));
															?>
															<div class="tg-displaybox">
																<i class="tg-deleteicon delete_asset fa fa-trash-o"></i>
																<div class="styles_assets_img">
																	<figure>
																		<img width="171" height="171" src="<?php echo esc_url($preview_image); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>">
																	</figure>
																</div>
																<div class="tg-radioandtitle">
																	<span class="tg-radio">
																		<?php
																		$checked = '';
																		if (isset($check_default) && $check_default == $key) {
																			$checked = 'checked';
																		}
																		?>
																		<input <?php echo esc_attr($checked); ?> type="radio" id="default-styles-<?php echo esc_attr($assets_count); ?>" name="styles[assets][default]" value="<?php echo esc_attr($assets_count); ?>">
																		<label for="default-styles-<?php echo esc_attr($assets_count); ?>" title="<?php esc_html_e('Set as Default', 'tailors-online'); ?>"></label>
																	</span>
																	<input value="<?php echo esc_attr($asset_title); ?>" type="text" name="styles[assets][data][<?php echo esc_attr($assets_count); ?>][image_title]" class="tg-formcontrol" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
																	<input type="hidden" name="styles[assets][data][<?php echo esc_attr($assets_count); ?>][media_id]" value="<?php echo esc_attr($asset_image_id); ?>">
																	<input type="hidden" name="styles[assets][data][<?php echo esc_attr($assets_count); ?>][media_url]" value="<?php echo esc_url($asset_image); ?>">
																</div>
															</div>
															<?php
															$assets_count++;
														}
													}
												}
												?>
											</div>
										</div>
										<div class="tg-fileupload">
											<div class="tg-dragfiles">
												<label for="file" class="styles_upload">
													<span class="tg-uploadtitle"><?php esc_html_e('Add step assets', 'tailors-online'); ?></span>
													<span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Styles Section End-->

					<!--Apparel and Steps Code Start-->
					<div class="apparel-and-steps-main-wrap">
						<div id="apparel-listing" class="apparel-listing">
							<div class="tg-box">
								<div class="tg-titlebox">
									<h3><?php esc_html_e('Add Apparels', 'tailors-online'); ?></h3>
								</div>
								<div class="tg-addcustomizer">
									<div class="customizer_tabs">
										<div class="tg-group step-parent-wrap">
											<div class="tg-steps">
											   <div class="customizer-apparel-data">
												<?php
													$apparel_tabs = 1;
													$data_step = 1;
													$apparels = !empty( $customizer_data->apparel ) ? $customizer_data->apparel : array();
													if (!empty($apparels)) {
														foreach ($apparels as $key => $value) {
															$apperal_key  = $key;
															$title = !empty($value['title']) ? $value['title'] : '';
															$apparel_back_id = !empty($value['apparel_back_id']) ? $value['apparel_back_id'] : '';
															$apparel_back_url = !empty($value['apparel_back_url']) ? $value['apparel_back_url'] : '';
															$apparel_front_id = !empty($value['apparel_front_id']) ? $value['apparel_front_id'] : '';
															$apparel_front_url = !empty($value['apparel_front_url']) ? $value['apparel_front_url'] : '';
															$apparel_placeholder	= plugins_url('images/apparel_placeholder.png', dirname(__FILE__));

															if ( !empty($apparel_back_id) ) {
																$apparel_back_class = 'image-back-added';
																$apparel_back_url_val	= $apparel_back_url;
															} else{
																 $apparel_back_class = '';
																 $apparel_back_url	= $apparel_placeholder;
																 $apparel_back_url_val	= '';
															}

															if ( !empty($apparel_front_id) ){
																$apparel_front_class = 'image-front-added';
																$apparel_front_url_val	= $apparel_front_url;
															} else{
																 $apparel_front_class = '';
																 $apparel_front_url	= $apparel_placeholder;
																 $apparel_front_url_val	= '';
															}


															?>
															<div class="apparel-counter" data-apparel_number="<?php echo intval($apparel_tabs); ?>">
																<div class="action-wrap">
																	<div class="tg-icons cus-apparel-action cus-actions-item"> 
																		<i class="fa fa-trash-o"></i>
																	</div>
																	<div class="tg-icons actio-mode cus-actions-item tg-accordion">
																		<i class="icon-pencil"></i>
																	</div>
																</div>
																<h4 class="apparel-control">
																	<span><?php esc_html_e('apparel', 'tailors-online'); ?>&nbsp;<?php echo intval($apparel_tabs); ?></span>
																</h4>
																
																<div class="apperel-main-wrapper tg-inner">
																	<div class="apparel-content-wrap">
																		<div class="apparel-front-back">
																			<div class="tg-inputfield tg-inputfull">
																				<input type="text" class="tg-formcontrol" value="<?php echo esc_attr($title); ?>" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][title]" placeholder="<?php esc_html_e('Add apparel title', 'tailors-online'); ?>">
																			</div>
																			<div class="tg-mediafilestitle"><?php esc_html_e('Apparel Front/Back images', 'tailors-online'); ?></div>
																			<div class="apparel_assets_container tg-mediafiles tg-scrollbar">

																				<div class="apparel_front tg-displaybox <?php echo esc_attr($apparel_front_class); ?>">
																					<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
																						<figure class="apparel_front_wrap">
																							<i class="tg-deleteicon delete_asset fa fa-trash-o delete_apparel_front_logo"></i>
																							<img width="171" src="<?php echo esc_url($apparel_front_url); ?>" data-placeholder="<?php echo esc_attr($apparel_placeholder); ?>" id="apparel_front_image">
																							<input type="hidden" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][apparel_front_id]" id="apparel_front_img_id" value="<?php echo intval($apparel_front_id); ?>">
																							<input type="hidden" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][apparel_front_url]" id="apparel_front_img_url" value="<?php echo esc_url($apparel_front_url_val); ?>">
																						</figure>
																						<div class="tg-radioandtitle"><strong><?php esc_html_e('Apparel front image', 'tailors-online'); ?></strong></div>
																					</div>
																					<div class="tg-fileupload">
																						<div class="tg-dragfiles">
																							<label for="file" class="apparel_front_img" data-apperal_no="<?php echo intval($apparel_tabs); ?>" data-step_number="1">
																								<span class="tg-uploadtitle"><?php esc_html_e('Apparel front image.', 'tailors-online'); ?></span>
																								<span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
																							</label>
																						</div>
																					</div>
																				</div>
																				<div class="apparel_back tg-displaybox <?php echo esc_attr($apparel_back_class); ?>">
																					<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">

																						<figure class="apparel_back_wrap">
																						   <i class="tg-deleteicon delete_asset fa fa-trash-o delete_apparel_back_logo"></i>
																							<img width="171" src="<?php echo esc_url($apparel_back_url); ?>" data-placeholder="<?php echo esc_attr($apparel_placeholder); ?>" id="apparel_back_image">
																							<input type="hidden" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][apparel_back_id]" id="apparel_back_img_id" value="<?php echo intval($apparel_back_id); ?>">
																							<input type="hidden" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][apparel_back_url]" id="apparel_back_img_url" value="<?php echo esc_url($apparel_back_url_val); ?>">
																						</figure>
																						<div class="tg-radioandtitle"><strong><?php esc_html_e('Apparel back image', 'tailors-online'); ?></strong></div>
																					</div>
																					<div class="tg-fileupload">
																						<div class="tg-dragfiles">
																							<label for="file" class="apparel_back_img" data-apperal_no="<?php echo intval($apparel_tabs); ?>" data-step_number="1">
																								<span class="tg-uploadtitle"><?php esc_html_e('Apparel back image.', 'tailors-online'); ?></span>
																								<span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
																							</label>
																						</div>
																					 </div>
																				</div>
																			</div>	
																		</div>
																		<div class="apparel-steps-main">
																			<div class="tg-mediafilestitle"><?php esc_html_e('Apparel Steps', 'tailors-online'); ?></div>
																			<div class="steps-main-wrap">
																				<?php
																					$steps_count = 1;
																					if (!empty($value['steps'])) {
																					foreach ($value['steps'] as $key => $value) {
																						$step_title = !empty($value['title']) ? $value['title'] : '';
																						$step_desc = !empty($value['description']) ? $value['description'] : '';
																						$step_location = !empty($value['step_location']) ? $value['step_location'] : '';
																						?>
																						<div class="step-counter"  data-step_number="<?php echo esc_attr($steps_count); ?>">
																							<div class="action-wrap">
																								<div class="tg-icons cus-step-action cus-actions-item">
																									<i class="fa fa-trash-o"></i>
																								</div>
																								<div class="tg-icons actio-mode cus-actions-item tg-accordion"> <i class="icon-pencil"></i> </div>
																								<div class="tg-icons cus-actions-item"> <i class="icon-move"></i> </div>
																							</div>
																							<h4 class="steps-control">
																								<span><?php esc_html_e('Step', 'tailors-online'); ?>&nbsp;<?php echo intval($steps_count); ?></span>
																								
																							</h4>
																							<div class="customizer-step-data tg-inner">
																								<div class="tg-displaybox">
																								  <div class="tg-radioandtitle"> 
																									<span class="tg-radio">
																										<input type="radio" id="is_front_<?php echo intval($apparel_tabs); ?>_<?php echo esc_attr($steps_count); ?>" class="tg-formcontrol" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][step_location]" value="is_front" <?php checked( $step_location, 'is_front', true ); ?>>
																									<label for="is_front_<?php echo intval($apparel_tabs); ?>_<?php echo esc_attr($steps_count); ?>"></label>
																									</span> 
																									<span class="step_location_label"><?php esc_html_e('IS FRONT?', 'tailors-online'); ?></span>
																								   </div>
																								</div>
																								<div class="tg-displaybox">
																								  <div class="tg-radioandtitle"> 
																									<span class="tg-radio">
																										<input type="radio" id="is_back_<?php echo intval($apparel_tabs); ?>_<?php echo esc_attr($steps_count); ?>" class="tg-formcontrol" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][step_location]" value="is_back" <?php checked( $step_location, 'is_back', true ); ?>>
																									<label for="is_back_<?php echo intval($apparel_tabs); ?>_<?php echo esc_attr($steps_count); ?>"></label>
																									</span> <span class="step_location_label"><?php esc_html_e('IS BACK?', 'tailors-online'); ?></span> 
																								  </div>
																								</div>
																								<div class="tg-inputfield tg-inputfull">
																									<input type="text" class="tg-formcontrol" value="<?php echo esc_attr($step_title); ?>" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][title]" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
																								</div>
																								<div class="tg-plceholder">
																									<textarea name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][description]"><?php echo force_balance_tags($step_desc); ?></textarea>
																								</div>
																								<div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets', 'tailors-online'); ?></div>
																								<div class="tg-mediafilesanduploader">
																									<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
																										<div class="assets_container">
																											<?php
																											if (!empty($value['assets'])) {
																												$assets_count = 1;
																												$check_default = !empty($value['assets']['default']) ? $value['assets']['default'] : '';
																												if (!empty($value['assets']['data'])) {
																													foreach ($value['assets']['data'] as $key => $value) {
$title = !empty($value['title']) ? $value['title'] : '';
																														$description = !empty($value['description']) ? $value['description'] : '';
																														$media_icon_id = !empty($value['media_icon_id']) ? $value['media_icon_id'] : '';
																														$media_icon_url = !empty($value['media_icon_url']) ? $value['media_icon_url'] : '';
																														$media_large_id = !empty($value['media_large_id']) ? $value['media_large_id'] : '';
																														$media_large_url = !empty($value['media_large_url']) ? $value['media_large_url'] : '';
																														$checked = '';
																														if (isset($check_default) && $check_default == $key) {
																															$checked = 'checked';
																														}
																														
																														
																														$large_preview_image	= !empty( $media_large_url ) ? $media_large_url : plugins_url('images/large.jpg', dirname(__FILE__));
																														$small_preview_image	= !empty( $media_icon_url ) ? $media_icon_url : plugins_url('images/small.jpg', dirname(__FILE__));
																														
																														$rand_id = rand(1,99999);
																														?>
																														<div class="step-asset-main" data-step="step<?php echo $apperal_key.$step_key.$key ?>">
																<div class="action-wrap">
																	<div class="tg-icons cus-asset-action cus-actions-item"> <i class="fa fa-trash-o"></i> </div>
																	<div class="tg-icons actio-mode cus-actions-item tg-accordion"> <i class="icon-pencil"></i> </div>
																	<div class="tg-icons cus-actions-item"> <i class="icon-move"></i> </div>
																						</div>
																						<h4><span><?php esc_html_e('Assets','tailors-online');?></span></h4>
																						<div class="customizer-step-data tg-inner">
																						<div class="tg-displaybox is_default_step">
																							<span class="tg-radio">
																								<input type="radio" id="default-step-<?php echo esc_attr($rand_id); ?>" <?php echo esc_attr($checked); ?> name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][default]" value="<?php echo esc_attr($assets_count); ?>">
																								<label for="default-step-<?php echo esc_attr($rand_id); ?>" title="<?php esc_html_e('Set as default','tailors-online');?>"></label>
																								<span class="step_location_label"><?php esc_html_e('Set as default','tailors-online');?></span>
																							</span>
																						</div>
																						<div class="tg-inputfield tg-inputfull">
																							<input type="text" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][title]" class="tg-formcontrol media_default" placeholder="<?php esc_html_e('Add title','tailors-online');?>" value="<?php echo esc_attr($title); ?>">
																						</div>
																						<div class="tg-plceholder">
																							<textarea placeholder="<?php esc_html_e('Short description','tailors-online');?>" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][description]"><?php echo esc_attr($description); ?></textarea>
																						</div>
																						<div class="tg-displaybox">
																							<i data-key="icon" class="upload_step_asset fa fa-upload"></i>
																							<div class="customizer_assets_img _screenshot">
																								<figure><img width="171" height="171" src="<?php echo esc_url($small_preview_image); ?>" alt=""></figure>
																								<input type="hidden" class="media_id" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][media_icon_id]" value="<?php echo intval($media_icon_id); ?>">
																								<input type="hidden" class="media_url" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][media_icon_url]" value="<?php echo esc_url($media_icon_url); ?>">
																							</div>
																							
																						</div>
																						<div class="tg-displaybox">
																							<i data-key="large" class="upload_step_asset fa fa-upload"></i>
																							<div class="customizer_assets_img _screenshot">
																								<figure><img width="171" height="171" src="<?php echo esc_url($large_preview_image); ?>" alt=""></figure>
																								<input type="hidden" class="media_id" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][media_large_id]" value="<?php echo intval($media_large_id); ?>">
																								<input type="hidden" class="media_url" name="customizer[apparel][<?php echo intval($apparel_tabs); ?>][steps][<?php echo esc_attr($steps_count); ?>][assets][data][<?php echo esc_attr($assets_count); ?>][media_large_url]" value="<?php echo esc_url($media_large_url); ?>">
																							</div>
																						</div>
																						</div>
																					</div>
																														<?php
																														$assets_count++;
																													}
																												}
																											}
																											?>
																										</div>
																									</div>
																									<div class="tg-fileupload">
																										<div class="tg-dragfiles">
																											<label for="file" class="add_step_asset" data-apperal_no="<?php echo intval($apparel_tabs); ?>" data-step_number="<?php echo esc_attr($steps_count); ?>">
																												<span class="tg-uploadtitle"><?php esc_html_e('Add step assets', 'tailors-online'); ?></span>
																												<span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
																											</label>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																						<?php
																						$data_step++;
																						$steps_count++;
																					} //Loop through Steps Items
																				} // Check if Steps Data Exists
																				?>
																			</div>
																			<a class="tg-btn add_new_customizer_tab" id="add_new_customizer_tab" href="javascript:;"><?php esc_html_e('Add More Steps', 'tailors-online'); ?></a>
																		 </div>
																	</div>
																</div>
															</div>
															<?php
															$apparel_tabs++;

														} // Loop through Apparel Items
													} //Check if Apparel Data Exists End
													?>
												 </div>
											 </div>
										 </div>
									</div>
									<input type="hidden" name="customizer_id" value="<?php echo intval( $_GET['customizer_id'] ); ?>">
									<input type="hidden" name="do_action" value="<?php echo esc_attr( $_GET['action'] ); ?>">
								</div>
							 </div>
							 <!--Apparel Button Code Start-->
							 <a class="tg-btn" id="add_new_apparel_tab" href="javascript:;"><?php esc_html_e('Add More Apparels', 'tailors-online'); ?></a>
						</div>
					</div>
					<!--Apparel and Steps Code End-->
					<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/admin/customizer-templates/template-customizer.php';?>
				</div>
				<?php
            }
            echo ob_get_clean();
        }
		
		/**
         * @access          public
         * @init            Add measurement
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc             Add new measurement form 
         */
		 
		public function tailer_add_new_measurement() {
			ob_start();
			$protocol = is_ssl() ? 'https' : 'http';
        ?>
        <div class="tg-addparameter">
            <div id="measurements_form">
                <div class="measurement-form-data">
                    <div class="tg-haslayout">
                       <div class="cus-select">
                       	<select class="tg-formcontrol" name="measurement[parameter_size]">
                            <option value=""><?php esc_html_e('Select Size', 'tailors-online'); ?></option>
                            <option value="in"><?php esc_html_e('In', 'tailors-online'); ?></option>
                            <option value="cm"><?php esc_html_e('Cm', 'tailors-online'); ?></option>
                        </select>
                       </div> 
                    </div>
                    <div class="tg-haslayout">
                        <input class="tg-formcontrol" type="text" name="measurement[parameter_video]" placeholder="<?php esc_html_e('Video Link', 'tailors-online'); ?>">
                    </div>
                </div>
                <div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets', 'tailors-online'); ?></div>
                <div class="tg-mediafilesanduploader">
                    <div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
                        <div class="measurement_assets"></div>
                    </div>
                    <div class="tg-fileupload">
                        <div class="tg-dragfiles">
                            <label for="file" class="measurement_assets_upload">
                                <span class="tg-uploadtitle"><?php esc_html_e('Add measurement assets', 'tailors-online'); ?></span>
                                <span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
                                <input id="file" type="file" name="file" class="tg-formcontrol">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/admin/customizer-templates/template-measurement.php';?>
        
        <?php
			echo ob_get_clean();
		}
        
		/**
         * @access          public
         * @init            Edit measurement
         * @package         Tailors Online
         * @subpackage      tailors-online/admin/hooks
         * @since           1.0
         * @desc            Edit measurement form
         */
        public function tailor_edit_measurement($settings,$term_id) {
            ob_start();
			$settings	= (object)$settings;
	
            if (isset($_GET['taxonomy']) 
				&& $_GET['taxonomy'] === 'measurements' 
				&& !empty($_GET['tag_ID'])
			) {

                if (!empty($settings)) {
                    $param_size = !empty($settings->parameter_size) ? $settings->parameter_size : '';
                    $param_video = !empty($settings->parameter_video) ? $settings->parameter_video : '';
					$measurement_assets = !empty($settings->assets) ? $settings->assets : array();
                    ?>
                     <table class="form-table">
						<tbody>
							<tr>
								<div class="tg-addparameter">
									<div id="measurements_form" class="edit-mode">
										<div class="measurement-form-data">
											<div class="tg-haslayout">
												<div class="cus-select">
													<select class="tg-formcontrol" name="measurement[parameter_size]">
														<option value=""><?php esc_html_e('Select Size', 'tailors-online'); ?></option>
														<?php
														$size_array = array(
															'in' => esc_html__('Inches', 'tailors-online'),
															'cm' => esc_html__('Centi Meter', 'tailors-online')
														);
														foreach ($size_array as $key => $value) {
															$selected = '';
															if ($param_size == $key) {
																$selected = 'selected';
															}
															echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="tg-haslayout">
												<input class="tg-formcontrol" value="<?php echo esc_url($param_video); ?>" type="text" name="measurement[parameter_video]" placeholder="Video Link">
											</div>
										</div>
										<div class="tg-mediafilestitle"><?php esc_html_e('Media Files / Assets', 'tailors-online'); ?></div>
										<div class="tg-mediafilesanduploader">
											<div id="tg-scrollbar" class="tg-mediafiles tg-scrollbar">
												<div class="measurement_assets">
													<?php
													if (!empty($measurement_assets)) {
														$check_default = !empty($measurement_assets['default']) ? $measurement_assets['default'] : '';
														if (!empty($measurement_assets['data'])) {
															$assets_count = 1;
															foreach ($measurement_assets['data'] as $key => $value) {
																$asset_image = !empty($value['media_url']) ? $value['media_url'] : '';
																$asset_image_id = !empty($value['media_id']) ? $value['media_id'] : '';
																$asset_title = !empty($value['image_title']) ? $value['image_title'] : '';
																?>
																<div class="tg-displaybox">
																	<i class="tg-deleteicon delete_asset fa fa-trash-o"></i>
																	<div class="measurement_assets_img">
																		<figure><img width="171" height="171" src="<?php echo esc_url($asset_image); ?>" alt="<?php esc_html_e('Measurement', 'tailors-online'); ?>"></figure>
																	</div>
																	<div class="tg-radioandtitle">
																		<span class="tg-radio">
																			<?php
																			$checked = '';
																			if (!empty($check_default) && $check_default == $key) {
																				$checked = 'checked';
																			}
																			?>
																			<input <?php echo esc_attr($checked); ?> type="radio" id="measurement_default_<?php echo esc_attr($assets_count); ?>" name="measurement[assets][default]" value="<?php echo esc_attr($assets_count); ?>">
																			<label for="measurement_default_<?php echo esc_attr($assets_count); ?>" title="<?php esc_html_e("Set as Default", 'tailors-online'); ?>"></label>
																		</span>
																		<input type="text" value="<?php echo esc_attr($asset_title); ?>" name="measurement[assets][data][<?php echo esc_attr($assets_count); ?>][image_title]" class="tg-formcontrol" placeholder="<?php esc_html_e('Add title', 'tailors-online'); ?>">
																		<input type="hidden" name="measurement[assets][data][<?php echo esc_attr($assets_count); ?>][media_id]" value="<?php echo esc_attr($asset_image_id); ?>">
																		<input type="hidden" name="measurement[assets][data][<?php echo esc_attr($assets_count); ?>][media_url]" value="<?php echo esc_attr($asset_image); ?>">
																	</div>
																</div>
																<?php
																$assets_count++;
															}
														}
													}
													?>
												</div>
											</div>
											<div class="tg-fileupload">
												<div class="tg-dragfiles">
													<label for="file" class="measurement_assets_upload">
														<span class="tg-uploadtitle"><?php esc_html_e('Add measurement assets', 'tailors-online'); ?></span>
														<span class="tg-browse"><?php esc_html_e('Select Files', 'tailors-online'); ?></span>
														<input id="file" type="file" name="file" class="tg-formcontrol">
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
                    			<?php include TailorsOnlineGlobalSettings::get_plugin_path().'/admin/customizer-templates/template-measurement.php';?>
							</tr>
						</tbody>
					</table>
                    <?php
                }
            }
            echo ob_get_clean();
        }

		/**
		 * @init            Add customizer in product page
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            Register Input Fields Settings
		 */
        public function cus_add_customizer_in_product() {
           if ( get_option('enable_wp_customizer') === 'yes' ) {
			   add_meta_box("customize_selection", 
					esc_html__("Select Customizer","tailors-online"),
					array(&$this,"cus_customizer_meta_box"), 
					"product", 
					"side", 
					"high", 
					null
				);
		   }
        }
		
		/**
		 * @init            Render customzer in product
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            Register Input Fields Settings
		 */
		public function cus_customizer_meta_box($object){
			global $wpdb;
			 $posts_array = array ();
			$args        = array (
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
		
		/**
		 * @init            Save custom post meta
		 * @package         Tailors Online
		 * @subpackage      tailors-online/admin/partials
		 * @since           1.0
		 * @desc            Register Input Fields Settings
		 */
		public function tailer_save_meta_data($post_id) {
			if (!is_admin()) {
				return;
			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}
			
			//Save customizer value
			if( get_post_type() === 'product' ){
				if( isset( $_POST['customizer_linked_id'] ) ){
					update_post_meta($post_id, 'customizer_linked_id',$_POST['customizer_linked_id']); //exit;
				}
			}
			
			//Update customizer data
			if( get_post_type() === 'wp_customizer' ){
				update_post_meta($post_id, '_customizer_style',$_POST['styles']); //styles
				update_post_meta($post_id, '_customizer_steps',$_POST['customizer']); //steps
			}
			
		}
		
		
    }

    new WpCustomizer_Admin_Hooks();
}