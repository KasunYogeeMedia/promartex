<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0
 * @package    Tailors Online
 * @subpackage Tailors Online/includes
 * @author     CodeZel <thecodezel@gmail.com>
 */
class TailorsOnline_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0
     */
    public static function deactivate() {
        self::deleteCustomizerTable();
        self::deleteMeasurementTable();
    }

    public static function deleteCustomizerTable() {
        global $wpdb;
        $table_name = $wpdb->prefix . "customizers";
        $sql = "DROP TABLE IF EXISTS $table_name";
        //$wpdb->query($sql);
    }

    public static function deleteMeasurementTable() {
        global $wpdb;
        $table_name = $wpdb->prefix . "measurements";
        $sql = "DROP TABLE IF EXISTS $table_name";
        //$wpdb->query($sql);
    }

}