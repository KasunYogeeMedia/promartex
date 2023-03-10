<?php

/**
 * Duplicate wpc-template functionality
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.1.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('WC_Admin_Duplicate_wpc_template')) :

    /**
     * WC_Admin_Duplicate_wpc-template Class
     */
    class WC_Admin_Duplicate_wpc_template {

        /**
         * Constructor
         */
        public function __construct() {
            add_action('admin_action_duplicate_wpc-template', array($this, 'duplicate_wpc_template_action'));
            add_filter('post_row_actions', array($this, 'dupe_link'), 10, 2);
            add_filter('page_row_actions', array($this, 'dupe_link'), 10, 2);
            add_action('post_submitbox_start', array($this, 'dupe_button'));
        }

        /**
         * Show the "Duplicate" link in admin wpc-templates list
         *
         * @param  array   $actions
         * @param  WP_Post $post Post object
         * @return array
         */
        public function dupe_link($actions, $post) {

            if (!current_user_can(apply_filters('woocommerce_duplicate_wpc-template_capability', 'manage_woocommerce'))) {
                return $actions;
            }

            if ($post->post_type != 'wpc-template') {
                return $actions;
            }

            $actions['duplicate'] = '<a href="' . wp_nonce_url(admin_url('edit.php?post_type=wpc-template&action=duplicate_wpc-template&amp;post=' . $post->ID), 'woocommerce-duplicate-wpc-template_' . $post->ID) . '" title="' . __('Make a duplicate from this wpc-template', 'woocommerce')
                    . '" rel="permalink">' . __('Duplicate', 'wpd') . '</a>';
            return $actions;
        }

        /**
         * Show the dupe wpc-template link in admin
         */
        public function dupe_button() {
            global $post;

            if (!current_user_can(apply_filters('woocommerce_duplicate_wpc-template_capability', 'manage_woocommerce'))) {
                return;
            }

            if (!is_object($post)) {
                return;
            }

            if ($post->post_type != 'wpc-template') {
                return;
            }
        }

        /**
         * Duplicate a wpc-template action.
         */
        public function duplicate_wpc_template_action() {

            if (empty($_REQUEST['post'])) {
                wp_die(__('No wpc-template to duplicate has been supplied!', 'wpd'));
            }

            // Get the original page
            $id = isset($_REQUEST['post']) ? absint($_REQUEST['post']) : '';

            check_admin_referer('woocommerce-duplicate-wpc-template_' . $id);

            $post = $this->get_wpc_template_to_duplicate($id);

            // Copy the page and insert it
            if (!empty($post)) {
                $new_id = $this->duplicate_wpc_template($post);
                // If you have written a plugin which uses non-WP database tables to save
                // information about a page you can hook this action to dupe that data.
                do_action('woocommerce_duplicate_wpc-template', $new_id, $post);

                // Redirect to the edit screen for the new draft page
                wp_redirect(admin_url('post.php?action=edit&post=' . $new_id));
                exit;
            } else {
                wp_die(__('Template creation failed, could not find original template:', 'wpd') . ' ' . $id);
            }
        }

        /**
         * Function to create the duplicate of the wpc-template.
         *
         * @param mixed  $post
         * @param int    $parent (default: 0)
         * @param string $post_status (default: '')
         * @return int
         */
        public function duplicate_wpc_template($post, $parent = 0, $post_status = '') {
            global $wpdb;

            $new_post_author = wp_get_current_user();
            $new_post_date = current_time('mysql');
            $new_post_date_gmt = get_gmt_from_date($new_post_date);

            if ($parent > 0) {
                $post_parent = $parent;
                $post_status = $post_status ? $post_status : 'publish';
                $suffix = '';
            } else {
                $post_parent = $post->post_parent;
                $post_status = $post_status ? $post_status : 'draft';
                $suffix = ' ' . __('(Copy)', 'wpd');
            }

            // Insert the new template in the post table
            $wpdb->insert(
                    $wpdb->posts, array(
                'post_author' => $new_post_author->ID,
                'post_date' => $new_post_date,
                'post_date_gmt' => $new_post_date_gmt,
                'post_content' => $post->post_content,
                'post_content_filtered' => $post->post_content_filtered,
                'post_title' => $post->post_title . $suffix,
                'post_excerpt' => $post->post_excerpt,
                'post_status' => $post_status,
                'post_type' => $post->post_type,
                'comment_status' => $post->comment_status,
                'ping_status' => $post->ping_status,
                'post_password' => $post->post_password,
                'to_ping' => $post->to_ping,
                'pinged' => $post->pinged,
                'post_modified' => $new_post_date,
                'post_modified_gmt' => $new_post_date_gmt,
                'post_parent' => $post_parent,
                'menu_order' => $post->menu_order,
                'post_mime_type' => $post->post_mime_type,
                    )
            );

            $new_post_id = $wpdb->insert_id;

            // Copy the taxonomies
            $this->duplicate_template_taxonomies($post->ID, $new_post_id, $post->post_type);

            // Copy the meta information
            $this->duplicate_post_meta($post->ID, $new_post_id);
            return $new_post_id;
        }

        /**
         * Get a wpc-template from the database to duplicate
         *
         * @param mixed $id
         * @return WP_Post|bool
         * @todo Returning false? Need to check for it in...
         * @see duplicate_wpc-template
         */
        private function get_wpc_template_to_duplicate($id) {
            global $wpdb;

            $id = absint($id);

            if (!$id) {
                return false;
            }

            $post = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID=$id");

            if (isset($post->post_type) && $post->post_type == 'wpc-template') {
                $id = $post->post_parent;
                $post = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE ID=$id");
            }

            return $post[0];
        }

        /**
         * Copy the taxonomies of a post to another post
         *
         * @param mixed $id
         * @param mixed $new_id
         * @param mixed $post_type
         */
        private function duplicate_template_taxonomies($id, $new_id, $post_type) {

            $taxonomies = get_object_taxonomies($post_type);

            foreach ($taxonomies as $taxonomy) {

                $post_terms = wp_get_object_terms($id, $taxonomy);
                $post_terms_count = sizeof($post_terms);

                for ($i = 0; $i < $post_terms_count; $i++) {
                    wp_set_object_terms($new_id, $post_terms[$i]->slug, $taxonomy, true);
                }
            }
        }

        /**
         * Copy the meta information of a post to another post
         *
         * @param mixed $id
         * @param mixed $new_id
         */
        private function duplicate_post_meta($id, $new_id) {
            global $wpdb;

            $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key NOT IN ( 'total_sales' );", absint($id)));

            if (count($post_meta_infos) != 0) {

                $sql_query_sel = array();
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

                foreach ($post_meta_infos as $meta_info) {
                    $meta_key = $meta_info->meta_key;
                    $meta_value = addslashes($meta_info->meta_value);
                    $sql_query_sel[] = "SELECT $new_id, '$meta_key', '$meta_value'";
                }

                $sql_query .= implode(' UNION ALL ', $sql_query_sel);
                $wpdb->query($sql_query);
            }
        }

    }

    endif;

return new WC_Admin_Duplicate_wpc_template();
