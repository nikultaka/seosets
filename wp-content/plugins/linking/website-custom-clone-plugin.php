<?php

/**
 * Plugin Name: Website Linking
 * Plugin URI: 
 * Description: Website Linking
 * Version: 1.0.0
 * Author: Nikul Panchal
 * Author URI: 
 * License: GPL2
 */

define('WCP_PLUGIN_LIKING_VERSION', '1.0.0');
define('WCP_PLUGIN_LIKING_DOMAIN', 'website-custom-plugin');
define('WCP_PLUGIN_LIKING_URL', WP_PLUGIN_URL . '/linking');

define('STORAGE_HOST','remotemysql.com');
define('STORAGE_USERNAME','lZDlp1nfbB');
define('STORAGE_PASSWORD','SpQcMVSdWe');
define('STORAGE_DB','lZDlp1nfbB');       

include_once(dirname(__FILE__) . "/linking/Controller.php");
include_once(dirname(__FILE__) . "/linking/db.php");  
register_activation_hook(__FILE__, 'createTables');

function createTables() {
    global $wpdb;
    global $db_table_name;
    $charset_collate = $wpdb->get_charset_collate();
    $db_table_name = $wpdb->prefix . 'linking';

    $sql = "CREATE TABLE `$db_table_name` (        
         `id` int(200) NOT NULL AUTO_INCREMENT,
         `title` varchar(200) NOT NULL,
         `description` varchar(200) NOT NULL,
         `summary` text NOT NULL,
         `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
         PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";  

    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
