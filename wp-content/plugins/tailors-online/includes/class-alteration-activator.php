<?php
/**
 * Fired during plugin activation
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    Elevator
 * @subpackage Tailors Online/includes
 * @author     CodeZel <thecodezel@gmail.com>
 */
class TailorsOnline_Activator {
	
	/**
	 * @init            Update settings
	 * @package         Tailors Online
	 * @subpackage      tailors-online/admin/partials
	 * @since           1.0
	 * @desc           Update default options
	 */
    public static function update_options() {
        update_option( 'enable_wp_customizer','yes');
		update_option( 'enable_cartbtn','no');
		update_option( 'wp_customizer_text','Customize Now!');
		update_option( 'wp_customizer_enable_measurements','yes');
		update_option( 'wp_customizer_on_detail','no');
		update_option( 'wp_customizer_color','#57c778');
		update_option( 'wp_customizer_force','no');
		update_option( 'wp_customizer_css','');
    }
	
    /**
	 * @init            init pages
	 * @package         Tailors Online
	 * @subpackage      tailors-online/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
    public static function activate() {
        self::update_options();
		self::create_pages();
    }
	

	/**
	 * @init            create pages
	 * @package         Tailors Online
	 * @subpackage      tailors-online/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
    public static function create_pages() {
		$pages =	array(
						'customizer' => array(
							'name'    => esc_html__( 'customizer','tailors-online' ),
							'title'   => esc_html__( 'Customizer','tailors-online' ),
							'content' => '[' . 'wp_customizer'. ']'
						),
					) ;

        foreach ( $pages as $key => $page ) {
            self::cus_create_page( esc_sql( $page['name'] ), $page['title'], $page['content'] );
        }

    }
    
	/**
	 * @init            create pages
	 * @package         Tailors Online
	 * @subpackage      tailors-online/admin/partials
	 * @since           1.0
	 * @desc            create page when plugin get activate
	 */
	public static function cus_create_page( $slug='', $page_title = '', $page_content = '') {
		global $wpdb;
		
		if ( strlen( $page_content ) > 0 ) {
			// Search for an existing page with the specified page content (typically a shortcode)
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		} else {
			// Search for an existing page with the specified page slug
			$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );
		}
		
		if ( $valid_page_found ) {
			return $valid_page_found;
		}
		
		// Search for a matching valid trashed page
		if ( strlen( $page_content ) > 0 ) {
			// Search for an existing page with the specified page content (typically a shortcode)
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		} else {
			// Search for an existing page with the specified page slug
			$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
		}
	
		if ( $trashed_page_found ) {
			$page_id   = $trashed_page_found;
			$page_data = array(
				'ID'             => $page_id,
				'post_status'    => 'publish',
			);
			wp_update_post( $page_data );
		} else {
			$page_data = array(
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'post_author'    => 1,
				'post_name'      => $slug,
				'post_title'     => $page_title,
				'post_content'   => $page_content,
				'comment_status' => 'closed'
			);
			$page_id = wp_insert_post( $page_data );
		}
	
		return $page_id;
	}
}