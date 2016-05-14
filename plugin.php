<?php
/**
* Plugin Name: 1WATF Plugin
* Plugin URI: http://sngrs.com
* Author: Rogier Sangers
**/

// Installeer tabel
global $wpdb;
$table_name = $wpdb->prefix . "watf_weight";
function watf_weight_install_table() { 
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      $sql = "CREATE TABLE " . $table_name . " (
      id int(11) unsigned NOT NULL AUTO_INCREMENT,
      date varchar(11) NOT NULL,
      user varchar(11) NOT NULL,
      weight int(11) NOT NULL,
      earned_points varchar(11) NOT NULL,
      current_points varchar(11) NOT NULL,
      PRIMARY KEY  (id)
      );";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
   }
}
register_activation_hook(__FILE__, 'watf_weight_install_table');

// Invoerveld gewicht
function watf_weight_submit_form($weight) {
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <label for="weight">Gewicht deze week></label>
    <input type="number" value="' . ( isset( $_POST['weight'] ) ? $weight : null ) . '">
     <input type="submit" name="submit" value="Invullen"/>
     </form>';
}

function watf_weight_submit_validation($weight) {
    global $reg_errors;
    $reg_errors = new WP_Error;
    
    if ( empty($weight)) {
        $reg_errors->add('field', 'Er is niks ingevuld')
    }
    
    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }
}

function watf_weight_submit_registration {
    global $reg_errors, $weight;
    if(1 > count($reg_errors->get_error_messages())) {
        
    }
}
?>