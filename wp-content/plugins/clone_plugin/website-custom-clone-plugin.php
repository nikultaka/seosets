<?php

/**
 * Plugin Name: SEO Booster
 * Plugin URI: 
 * Description: Custom Clone Plugin
 * Version: 1.0.0
 * Author: Nikul Panchal
 * Author URI: 
 * License: GPL2
 */

define('WCP_PLUGIN_VERSION', '1.0.0');
define('WCP_PLUGIN_DOMAIN', 'website-custom-plugin');
define('WCP_PLUGIN_URL', WP_PLUGIN_URL . '/Website-Custome-Plugin');

include_once(dirname(__FILE__) . "/Clone/Controller.php");
register_activation_hook(__FILE__, 'myPluginCreateTable');

function myPluginCreateTable(){
    global $wpdb;
    global $db_table_name;
    $charset_collate = $wpdb->get_charset_collate();
    $db_table_name = $wpdb->prefix . 'clone';

    $sql = "CREATE TABLE `$db_table_name` (
     `id` int(200) NOT NULL AUTO_INCREMENT,
     `clonename` varchar(200) NOT NULL,
     `pages` varchar(200) NOT NULL,
     `tags` text NOT NULL,
     `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `pages_status` varchar(200) NOT NULL,
     `page_insert_id` varchar(5000) NOT NULL,
     PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=374 DEFAULT CHARSET=latin1";


    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
