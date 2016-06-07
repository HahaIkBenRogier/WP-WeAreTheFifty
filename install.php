<?php

// Installeer tabel
function watf_weight_install_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "watf_weight";
        if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
          $sql = "CREATE TABLE " . $table_name . " (
          id int(11) unsigned NOT NULL AUTO_INCREMENT,
          date int(11) NOT NULL,
          user int(11) NOT NULL,
          weight int(11) NOT NULL,
          PRIMARY KEY  (id)
          );";
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

?>
