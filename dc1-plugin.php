<?php
/*
* Plugin Name: DC1 Plugin
* Plugin URI: https://icode.guru
* Author: Team Six
* Author URI: https://teamsix.github.io
* Description: Plugin for icodeguru website to add user dashboard.
* Version: 1.0.0
* License: GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: dc1-plugin
*/

// Abort if accessed directly
if (!defined('ABSPATH')) {
    die;
}

// Define constants
define('DC1_VERSION', '1.0.0');
define('DC1_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DC1_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once DC1_PLUGIN_DIR . 'inc/scripts.php';
require_once DC1_PLUGIN_DIR . 'inc/add_btn.php';

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'dc1_plugin_activate');
register_deactivation_hook(__FILE__, 'dc1_plugin_deactivate');

// Activation: Create custom table
function dc1_plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dc1_users';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        user_id INT(11) NULL,
        name VARCHAR(64) NULL,
        email VARCHAR(64) NULL,
        password VARCHAR(64) NULL,
        ielts VARCHAR(24) NULL,
        typing_speed VARCHAR(24) NULL,
        total_hackathon VARCHAR(24) NULL,
        win_hackathon VARCHAR(24) NULL,
        courses VARCHAR(24) NULL,
        webinars VARCHAR(24) NULL,
        cgpa VARCHAR(24) NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    update_option('dc1_button_active', true); // Enable the button
}

// Deactivation: Drop custom table
function dc1_plugin_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dc1_users';
    $wpdb->query("DROP TABLE IF EXISTS $table_name;");
    delete_option('dc1_button_active');
}
