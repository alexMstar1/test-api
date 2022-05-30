<?php
/**
 * @since 1.0.0
 *
 * @package  Forbidden_Island
 * @subpackage  Forbidden_Island/includes
 */

class Forbidden_Island_Activator
{
    public static function activate()
    {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'residents';
        $charset_collate = $wpdb->get_charset_collate();
        $query = "CREATE TABLE {$table_name}(
        id int(20) unsigned NOT NULL auto_increment,
        name varchar(255) NOT NULL default '',
        PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($query);
        $table_name = $wpdb->get_blog_prefix() . 'items';
        $charset_collate = $wpdb->get_charset_collate();
        $query = "CREATE TABLE {$table_name}(
        id int(20)  unsigned NOT NULL  auto_increment,
        name varchar(255) NOT NULL default '',
        value int(20) DEFAULT NULL,
        PRIMARY KEY (id)
        )$charset_collate;";
        dbDelta($query);
        $table_name = $wpdb->get_blog_prefix() . 'resident_items';
        $charset_collate = $wpdb->get_charset_collate();
        $query = "CREATE TABLE {$table_name}(
        id  int(20) unsigned NOT NULL auto_increment,
        name varchar(255) NOT NULL default '',
        value int(20) DEFAULT NULL,
        PRIMARY KEY(id)
        )$charset_collate;";
        dbDelta($query);
        $table_name = $wpdb->get_blog_prefix() . 'auction';
        $charset_collate = $wpdb->get_charset_collate();
        $query = "CREATE TABLE {$table_name}(
            id   int(20) unsigned NOT NULL autor_increment,
            seller_id int (20) DEFAULT NULL,
            customer_id int (20) DEFAULT NULL,
            status varchar(255) NOT NULL default '',         
            seller_items varchar(255) NOT NULL default '',
            customer_items varchar(255) NOT NULL default '',
            PRIMARY KEY (id)
         ){$charset_collate};";

        dbDelta($query);
        run_forbidden_island();
    }


}