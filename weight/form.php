<?php

// Invoerveld gewicht
function watf_weight_submit_form() {
    if ( !is_user_logged_in() ) {
        echo "Je bent niet ingelogd!";
        auth_redirect();
    } else {
         echo '
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
        <label for="weight">Gewicht deze week</label>
        <input type="number" value="" name="weight">
        <input type="submit" name="submit" value="Invullen"/>
        </form>';
    };

};

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
    $table_weight = $wpdb->prefix . "watf_weight";
    $table_points = $wpdb->prefix . "watf_points";
    global $reg_errors, $weight;
    if(1 > count($reg_errors->get_error_messages())) {
        $date = time();
        $user = get_current_user_id();
        $points_new = $passedvar * 20;
        $sql_w = "INSERT INTO ".$table_weight." (`date`, `user`, `weight`) VALUES ('".$date."', '".$user."', '".$points_new."')";
        $result = $wpdb->get_results ("SELECT id FROM ".$table_points." WHERE user = '".$user."'");
        if (count ($result) > 0) {
            $row = current ($result);
            $wpdb->query ("UPDATE ".$table_points." SET points = points + ".$points_new.", lastlogin = ".$date." WHERE user = '".$user."'");
        } else {
            $wpdb->query ("INSERT INTO ".$table_points." (user, points, lastlogin) VALUES ('".$user."', '".$points_new."', '".$date."')");
        }
        $wpdb->query($sql_w);
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
