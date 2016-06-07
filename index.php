<?php
/**
* Plugin Name: 1WATF Plugin
* Plugin URI: http://sngrs.com
* Author: Rogier Sangers
**/

include_once( plugin_dir_path( __FILE__ ) . 'install.php' );
include_once( plugin_dir_path( __FILE__ ) . '/weight/form.php' );
include_once( plugin_dir_path( __FILE__ ) . '/weight/graph.php' );

add_action( 'wp_enqueue_scripts', 'watf_add_styles_scripts' );
function watf_add_styles_scripts() {
    wp_enqueue_script('chartjs-style','https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js');
}

?>
