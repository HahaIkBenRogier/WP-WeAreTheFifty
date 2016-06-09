<?php
/**
* Plugin Name: 1WATF Plugin
* Plugin URI: http://sngrs.com
* Author: Rogier Sangers
**/

include_once( plugin_dir_path( __FILE__ ) . '/weight/form.php' );
include_once( plugin_dir_path( __FILE__ ) . '/weight/graph.php' );

// Installeer tabel
function watf_weight_install_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "watf_weight";
        if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
          $sql = "CREATE TABLE " . $table_name . " (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `date` int(11) NOT NULL,
          `user` int(11) NOT NULL,
          `weight` int(11) NOT NULL,
          `earned_points` int(11) NOT NULL,
          `current_points` int(11) NOT NULL,
          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'watf_weight_install_table');

function watf_weight_install_table2() {
    global $wpdb;
    $table_name = $wpdb->prefix . "watf_points";
        if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
          $sql = "CREATE TABLE " . $table_name . " (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user` int(11) DEFAULT NULL,
            `points` int(11) DEFAULT NULL,
            `lastlogin` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          );";
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'watf_weight_install_table2');

function watf_weight_install_table3() {
    global $wpdb;
    $table_name = $wpdb->prefix . "watf_users";
        if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
          $sql = "CREATE TABLE " . $table_name . " (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `user` int(11) NOT NULL,
          `Street` varchar(255) NOT NULL DEFAULT '',
          `AdressNumber` varchar(255) NOT NULL DEFAULT '',
          `PostalCode` varchar(6) NOT NULL DEFAULT '',
          `Neighbourhood` varchar(255) DEFAULT NULL,
          `City` varchar(255) DEFAULT NULL,
          `State` varchar(255) DEFAULT NULL,
          `HousingGroup` varchar(255) NOT NULL DEFAULT '',
          `registered_on` int(11) NOT NULL,
          `activated` tinyint(1) DEFAULT NULL,
          `activated_on` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'watf_weight_install_table3');

add_action( 'wp_enqueue_scripts', 'watf_add_styles_scripts' );
function watf_add_styles_scripts() {
    wp_enqueue_script('chartjs-style','https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js');
}

if( ! class_exists( 'Smashing_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
};
$updater = new Smashing_Updater( __FILE__ );
$updater->set_username( 'HahaIkBenRogier' );
$updater->set_repository( 'WP-WeAreTheFifty' );
// $updater->authorize( '' ); // Your auth code goes here for private repos
$updater->initialize();

?>
