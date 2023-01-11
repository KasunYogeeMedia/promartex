<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/admin
 */

/**
 * @init            Genral Settings
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Default Genral Settings
 */
if (!function_exists('tab_general_settings')) {
    function tab_general_settings() {
		ob_start();
		?>
		<div id="tabone">
			<div class="tg-titlebox">
				<h3><?php esc_html_e('General Options', 'tailors-online'); ?></h3>
			</div>
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('wp-customizer-general-settings-group'); ?>
				<?php do_settings_sections('wp-customizer-general-settings-group'); ?>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Enable Product Customizer', 'tailors-online'); ?></div>
					<div class="tg-btnradio">
						<input type="radio" id="customiseoptionleft" name="enable_wp_customizer" value="yes" <?php checked(esc_attr(get_option('enable_wp_customizer')), 'yes', true); ?>>
						<label for="customiseoptionleft"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="customiseoptionright" name="enable_wp_customizer" value="no" <?php checked(esc_attr(get_option('enable_wp_customizer')), 'no', true); ?>>
						<label for="customiseoptionright"><?php esc_html_e('No', 'tailors-online'); ?></label>
						
					</div>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('By enabling these settings, customizer button will be display at product detail page', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Replace add to cart button', 'tailors-online'); ?></div>
					<div class="tg-btnradio">
						<input type="radio" id="enable_cartbtn_left" name="enable_cartbtn" value="yes" <?php checked(esc_attr(get_option('enable_cartbtn')), 'yes', true); ?>>
						<label for="enable_cartbtn_left"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="enable_cartbtn_right" name="enable_cartbtn" value="no" <?php checked(esc_attr(get_option('enable_cartbtn')), 'no', true); ?>>
						<label for="enable_cartbtn_right"><?php esc_html_e('No', 'tailors-online'); ?></label>
					</div>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('By enabling this settings, product add to cart button will be replace with customizer button on shop page.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Replace add to cart on detail', 'tailors-online'); ?></div>
					<div class="tg-btnradio">
						<input type="radio" id="enable_cartbtn_left_detail" name="enable_cartbtn_detail" value="yes" <?php checked(esc_attr(get_option('enable_cartbtn_detail')), 'yes', true); ?>>
						<label for="enable_cartbtn_left_detail"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="enable_cartbtn_right_detail" name="enable_cartbtn_detail" value="no" <?php checked(esc_attr(get_option('enable_cartbtn_detail')), 'no', true); ?>>
						<label for="enable_cartbtn_right_detail"><?php esc_html_e('No', 'tailors-online'); ?></label>
					</div>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('Product add to cart button will be replace with customizer button on detail page. Leave it No, to show both buttons', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-inputfield">
					<label><?php esc_html_e('Enter Text For Customizer Button', 'tailors-online'); ?></label>
					<input type="text" class="tg-formcontrol" name="wp_customizer_text" value="<?php echo esc_attr(get_option('wp_customizer_text', 'Customize Now!')); ?>" placeholder="<?php esc_html_e('Customize Now', 'tailors-online'); ?>" >
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('This text will be used for customizer button at product detail page.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Enable Measurements', 'tailors-online'); ?></div>
					<div class="tg-btnradio tg-btnradio-two">
						<input type="radio" id="measurementsleft" name="wp_customizer_enable_measurements" value="yes" <?php checked(esc_attr(get_option('wp_customizer_enable_measurements')), 'yes', true); ?>>
						<label for="measurementsleft"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="measurementsright" name="wp_customizer_enable_measurements" value="no" <?php checked(esc_attr(get_option('wp_customizer_enable_measurements')), 'no', true); ?>>
						<label for="measurementsright"><?php esc_html_e('No', 'tailors-online'); ?></label>
					</div>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('If measurements will be enable then measurements settings will be shown at cart and checkout page.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Enable customizer on detail page', 'tailors-online'); ?></div>
					<div class="tg-btnradio tg-btnradio-two">
						<input type="radio" id="cus_on_detail_yes" name="wp_customizer_on_detail" value="yes" <?php checked(esc_attr(get_option('wp_customizer_on_detail')), 'yes', true); ?>>
						<label for="cus_on_detail_yes"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="cus_on_detail_no" name="wp_customizer_on_detail" value="no" <?php checked(esc_attr(get_option('wp_customizer_on_detail')), 'no', true); ?>>
						<label for="cus_on_detail_no"><?php esc_html_e('No', 'tailors-online'); ?></label>
					</div>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('This setting will override customizer button with customizer steps at product detail page.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-btnradiafield">
					<div class="tg-radiotitle"><?php esc_html_e('Force Measurements?', 'tailors-online'); ?></div>
					<div class="tg-btnradio tg-btnradio-two">
						<input type="radio" id="wp_customizer_force_yes" name="wp_customizer_force" value="yes" <?php checked(esc_attr(get_option('wp_customizer_force')), 'yes', true); ?>>
						<label for="wp_customizer_force_yes"><?php esc_html_e('Yes', 'tailors-online'); ?></label>
						<input type="radio" id="wp_customizer_force_no" name="wp_customizer_force" value="no" <?php checked(esc_attr(get_option('wp_customizer_force')), 'no', true); ?>>
						<label for="wp_customizer_force_no"><?php esc_html_e('No', 'tailors-online'); ?></label>
					</div> 
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('Force measurements on cart and checkout page.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-inputfield">
					<label><?php esc_html_e('Color Scheme', 'tailors-online'); ?></label>
					<div class="tl-colorpicker">
						<input type="text" class="tg-formcontrol plugin_color" name="wp_customizer_color" value="<?php echo esc_attr(get_option('wp_customizer_color')); ?>">
					</div>
					
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('This color will be used in all steps at front-end.', 'tailors-online'); ?></span>
					</span>
				</div>
				<div class="tg-inputfield">
					<label><?php esc_html_e('Custom Css', 'tailors-online'); ?></label>
					<textarea type="text" class="tg-formcontrol wp_customizer_css" name="wp_customizer_css" placeholder="<?php esc_html_e('Custom Css', 'tailors-online'); ?>" ><?php echo esc_attr(get_option('wp_customizer_css', '')); ?></textarea></textarea>
					<span class="tg-tooltipbox">
						<i>?</i>
						<span class="tooltiptext"><?php esc_html_e('Add you custom styling in this box area', 'tailors-online'); ?></span>
					</span>
				</div>
				<?php submit_button(); ?>
			</form>
		   
		</div>
		<?php
		echo ob_get_clean();
    }
}

/**
 * @init            System Settings
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Tab System Settings
 */
if (!function_exists('tab_system_settings')) {  
    function tab_system_settings() {
        ob_start();

        ?>
        <div id="tg-main" class="tg-main tg-features settings-main-wrap">
            <div class="tg-featureswelcomebox">
                <figure><img src="<?php echo TailorsOnlineGlobalSettings::get_plugin_url();?>/admin/images//welcome/logo.jpg" alt="<?php esc_html_e('logo','tailors-online');?>"></figure>
                <div class="tg-welcomecontent">
                    <h3><?php esc_html_e('Welcome to','tailors-online');?>&nbsp;<?php echo TailorsOnlineGlobalSettings::get_plugin_name();?>&nbsp;<?php echo TailorsOnlineGlobalSettings::get_plugin_verion();?></h3>
                    <div class="tg-description">
                        <p><?php esc_html_e('Tailor Online is a premiere WooCommerce plugin for online custom tailoring. It is enriched with excellent features including unlimited customizers, online design and submission, email notifications, measurement submission for each order and a lot more.','tailors-online');?></p>
                        <p><?php esc_html_e('The excellent and robust code is backed up by contemporary and user friendly design which is almost ready made for tailors and businesses/shops related to online tailoring.','tailors-online');?></p>
                    </div>
                </div>
            </div>
            <div class="tg-featurescontent">
                <div id="tg-pluginslider" class="tg-pluginslider">
                    <div class="item">
                        <figure><img src="<?php echo TailorsOnlineGlobalSettings::get_plugin_url();?>/admin/images//welcome/banner.png" alt="<?php esc_html_e('Banner','tailors-online');?>"></figure>
                        <div class="tg-slidercontent">
                            <h3><span><?php esc_html_e('Best Wordpress Plugin For','tailors-online');?></span><?php esc_html_e('Online Tailoring','tailors-online');?></h3>
                            <div class="tg-description">
                                <p><?php esc_html_e('We have found the perfect balance between usability, design and code robustness. Tailor Online is a powerful plugin which is affordable and ready made for online custom design and tailoring.
It is fully responsive and works perfectly on all devices.
','tailors-online');?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tg-twocolumns">
                    <div class="tg-content">
                        <div class="tg-boxarea">
                            <div class="tg-title">
                                <h3><?php esc_html_e('Minimum System Requirements','tailors-online');?></h3>
                            </div>
                            <div class="tg-contentbox">
                                <ul class="tg-liststyle tg-dotliststyle tg-twocolumnslist">
                                    <li>max_execution_time = 1000</li>
                                    <li>max_input_time = 1000</li>
                                    <li>memory_limit = 1000</li>
                                    <li>post_max_size = 100M</li>
                                    <li>upload_max_filesize = 100M</li>
                                </ul>
                            </div>
                        </div>	
                    </div>
                    <aside class="tg-sidebar">
                        <div class="tg-widgetbox">
                            <div class="tg-title">
                                <h3><?php esc_html_e('Tailors Online Video\'s','tailors-online');?></h3>
                            </div>
                            <figure>
                            	<div style="position:relative;height:0;padding-bottom:56.25%"><iframe src="https://www.youtube.com/embed/miJjv_z1ecU?ecver=2" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe></div>
                            </figure>
                            <ul>
                                <li><a target="_blank" href="https://www.youtube.com/channel/UCSKhlG1JDxtUI66BgMzrRSw"><?php esc_html_e('For More Videos View Our Channel','tailors-online');?></a></li>
                            </ul>
                        </div>
                        <div class="tg-widgetbox tg-widgetboxquicklinks">
                            <div class="tg-title">
                                <h3><?php esc_html_e('Quick Links','tailors-online');?></h3>
                            </div>
                            <a class="tg-btn" target="_blank" href="https://themeforest.net/user/codezel"><?php esc_html_e('Get a quick help','tailors-online');?></a>
                        </div>
                    </aside>
                </div>
                <div class="tg-socialandcopyright">
                    <div class="tg-followus">
                        <span><?php esc_html_e('Follow us','tailors-online');?></span>
                        <ul class="tg-socialicons">
                            <li class="tg-facebook"><a target="_blank" href="https://web.facebook.com/CodeZel-1837404279918136/"><i class="fa fa-facebook"></i></a></li>
                            <li class="tg-twitter"><a target="_blank" href="https://twitter.com/thecodezel"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <span class="tg-copyright"><?php echo date('Y');?>&nbsp;<?php esc_html_e('All Rights Reserved','tailors-online');?> &copy; <a target="_blank"  accesskey=""href="https://themeforest.net/user/codezel"><?php esc_html_e('CodeZel','tailors-online');?></a></span>
                </div>
            </div>
        </div>	
        <?php
        echo ob_get_clean();
    }
}


/**
 * @init            tab url
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('cus_prepare_final_url')) {

    function cus_prepare_final_url($tab='',$page='wp-customizer-admin') {
		$permalink = '';
		$permalink = add_query_arg( 
								array(
									'?post_type=wp_customizer&page'	=>   urlencode( $page ) ,
									'tab'	=>   urlencode( $tab ) ,
								)
							);	
		
		return esc_url( $permalink );
	}
}

/**
 * @init            migration from 1.3 to latest version
 * @package         Tailors Online
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('code_migration')) {
	function code_migration(){
		$migration = array();
		//posts
		$query_args = array(
			'posts_per_page'        => -1,
			'post_type'             => 'wp_customizer',
			'post_status'           => 'publish',
			'ignore_sticky_posts'   => 1
		);
		
		$query = get_posts($query_args);
		
		foreach( $query as $key => $item ){
			$customizer_data	= (object)cus_get_customizer_data($item->ID);

			$apparel_tabs 	= 1;
			$data_step 		= 1;
			$apparels 		= !empty( $customizer_data->apparel ) ? $customizer_data->apparel : array();

			if (!empty($apparels)) {
				foreach ($apparels as $key => $value) {
					$apperal_key  = $key;
					$migration['apparel'][$apperal_key]['title'] = !empty($value['title']) ? $value['title'] : '';
					$migration['apparel'][$apperal_key]['apparel_back_id'] = !empty($value['apparel_back_id']) ? $value['apparel_back_id'] : '';
					$migration['apparel'][$apperal_key]['apparel_back_url'] = !empty($value['apparel_back_url']) ? $value['apparel_back_url'] : '';
					$migration['apparel'][$apperal_key]['apparel_front_id'] = !empty($value['apparel_front_id']) ? $value['apparel_front_id'] : '';
					$migration['apparel'][$apperal_key]['apparel_front_url'] = !empty($value['apparel_front_url']) ? $value['apparel_front_url'] : '';

					if (!empty($value['steps'])) {
						foreach ($value['steps'] as $key => $value) {
							$migration['apparel'][$apperal_key]['steps'][$key]['title'] = !empty($value['title']) ? $value['title'] : '';
							$migration['apparel'][$apperal_key]['steps'][$key]['description'] = !empty($value['description']) ? $value['description'] : '';
							$migration['apparel'][$apperal_key]['steps'][$key]['step_location'] = !empty($value['step_location']) ? $value['step_location'] : 'is_front';

							if (!empty($value['assets'])) {
								$assets_count = 1;
								$migration['apparel'][$apperal_key]['steps'][$key]['assets']['default'] = 1;
								if (!empty($value['assets']['data'])) {
									foreach ($value['assets']['data'] as $akey => $value) {
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['title'] = !empty($value['image_title']) ? $value['image_title'] : '';
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['description'] = !empty($value['image_title']) ? $value['image_title'] : '';
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['media_icon_id'] = !empty($value['media_id']) ? $value['media_id'] : '';
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['media_icon_url'] = !empty($value['media_url']) ? $value['media_url'] : '';
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['media_large_id'] = !empty($value['media_id']) ? $value['media_id'] : '';
										$migration['apparel'][$apperal_key]['steps'][$key]['assets']['data'][$akey]['media_large_url'] = !empty($value['media_url']) ? $value['media_url'] : '';
									}
								}
							} else{
								$migration = array();
							}
						}
					} else{
						$migration = array();
					}
				}
			}

			$db_val = get_post_meta($item->ID,'_customizer_steps', true);
			//update previous data in new key for safe play
			update_post_meta($item->ID,'_customizer_steps_1_3',$db_val);
			
			
			//migration
			update_post_meta($item->ID,'_customizer_steps',$migration);
		}
	}
}
