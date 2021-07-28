<?php

/**
 * Plugin Name: Video Quiz Linking
 * Plugin URI: 
 * Description: Video Quiz Linking
 * Version: 1.0.0
 * Author: Nikul Panchal
 * Author URI: 
 * License: GPL2
 */

define('WCP_QUIZ_LINKING_PLUGIN_VERSION', '1.0.0');
define('WCP_QUIZ_LINKING_PLUGIN_DOMAIN', 'website-custom-plugin');
define('WCP_QUIZ_LINKING_PLUGIN_URL', WP_PLUGIN_URL . '/Website-Custome-Plugin');

@define("WP_MEMORY_LIMIT","512M");       

include_once(dirname(__FILE__) . "/linking/Controller.php");
register_activation_hook(__FILE__, 'quizLinkingCreateTable');

function quizLinkingCreateTable() {
    global $wpdb;
    global $db_table_name;
    $charset_collate = $wpdb->get_charset_collate();
    $db_table_name = $wpdb->prefix . 'video_quiz_linking';
    $db_user_quiz = $wpdb->prefix . 'user_quiz';

    $sql = "CREATE TABLE `$db_table_name` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `video_name` varchar(255) NOT NULL,
        `video_url` varchar(255) NOT NULL,
        `quiz_id` int(11) NOT NULL,
        `amount` decimal(5,2) NOT NULL,
        `status` tinyint(1) NOT NULL,
        `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }    

    $sql = "CREATE TABLE `$db_user_quiz` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,    
        `video_id` int(11) NOT NULL,
        `is_paid` tinyint(1) NOT NULL,
        `status` tinyint(1) NOT NULL,    
        `created_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_user_quiz'") != $db_table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }    


}
