<?php
/**
 * @since 1.0.0
 *
 * @package  Forbidden_Island
 * @subpackage  Forbidden_Island/includes
 */
class Fobidden_Island_Deactivator{
    public static function deactivate(){
        global $wpdb;
        $table_name = $wpdb ->get_blog_prefix() . 'residents';
        require_once (ABSPATH . wp_admin/includes/upgrade.php);
        $query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($query);

        $table_name = $wpdb->get_blog_prefix() . 'items';
        $query = "DROP TABLE IF EXISTS {$table_name}";
        $wpdb->query($query);

        $table_name = $wpdb -> get_blog_prefix(). 'resident_items';
        $query = "DROP TABLE IF EXISTS{$table_name}";
        $wpdb->query($query);

        $table_name = $wpdb->get_blog_prefix(). 'auction';
        $query = "DROP TABLE IF EXISTS{$table_name}";
        $wpdb->query($query);
    }
}