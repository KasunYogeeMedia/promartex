<?php
/**
 *  Plugin String Constants
 */
 
if (!function_exists('customize_prepare_constants')) {
    function customize_prepare_constants() {

		wp_localize_script('tailors_online_lib', 'scripts_vars', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'del_apparel_title' => esc_html__('Delete apparel?','tailors-online'),
			'del_apparel_message' => esc_html__('Are you sure you want to delete this apparel?','tailors-online'),
			'del_step_title' => esc_html__('Delete Step?','tailors-online'),
			'del_step_message' => esc_html__('Are you sure you want to delete this step?','tailors-online'),
		));
	}
}