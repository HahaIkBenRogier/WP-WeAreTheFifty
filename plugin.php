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
function watf_weight_submit_form() {
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <label for="weight">Gewicht deze week</label>
    <input type="number" value="' . ( isset( $_POST['weight'] )) . '" name="weight">
    <input type="submit" name="submit" value="Invullen"/>
    </form>';
}

function watf_weight_submit_validation($weight) {
    global $reg_errors;
    $reg_errors = new WP_Error;
    
    if ( empty($weight)) {
        $reg_errors->add('field', 'Er is niks ingevuld');
    };
    
    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        };
    };
};

function watf_weight_submit_complete($passedvar) {
    global $wpdb;
    $table_name = $wpdb->prefix . "watf_weight";
    global $reg_errors, $weight;
    if(1 > count($reg_errors->get_error_messages())) {
        $date = time();
        $user = get_current_user_id();
        $weight = $passedvar;
        $earned = $weight;
        $sql_current = "SELECT current_points FROM " . $table_name . " WHERE user = '". $user . "' ORDER BY date DESC LIMIT 0,1";
        global $wpdb;
        $currentpoints = $wpdb->get_var($sql_current, ARRAY_A);
        $current = $currentpoints;
        $sql = "INSERT INTO ".$table_name." (`date`, `user`, `weight`, `earned_points`, `current_points`) VALUES ('".$date."', '".$user."', '".$weight."', '".$earned."', '".$current."')";
        $wpdb->query($sql);
        echo "Done!";
    };
};

function watf_weight_submit_function() {
    if ( isset($_POST['submit'] ) ) {
        watf_weight_submit_validation($_POST['weight']);
        watf_weight_submit_complete($_POST['weight']);
    };
    watf_weight_submit_form();
};
add_shortcode("watf_weightsubmit","watf_weight_submit_shortcode");
function watf_weight_submit_shortcode() {
    ob_start();
    watf_weight_submit_function();
    return ob_get_clean();
};
?>