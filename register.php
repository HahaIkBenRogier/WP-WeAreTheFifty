<?php

function watf_user_postalcode_check($string) {
  $string = preg_replace('/\s+/', '', $string);
  if (strlen($string) == 6) {
    $cijfers = substr($string, 0, -2);  // returns "4 cijfers"
    $letters = substr($string, -2);  // returns "2 letters"

    if (ctype_digit($cijfers)) {
      if (ctype_alpha($letters)) {
        echo $string;
      } else {
        return "";
      }
    } else {
      return "";
    }
  } else {
    return "";
  }
}

function watf_user_register_form () {
  echo '
  <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
<div>
<label for="username">Username <strong>*</strong></label>
<input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
</div>

<div>
<label for="password">Password <strong>*</strong></label>
<input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
</div>

<div>
<label for="email">Email <strong>*</strong></label>
<input type="email" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
</div>

<div>
<label for="firstname">First Name</label>
<input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
</div>

<div>
<label for="lastname">Last Name</label>
<input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
</div>

<div>
<label for="street">Straat*</label>
<input type="text" name="street" value="' . ( isset( $_POST['street']) ? $street : null ) . '">
</div>

<div>
<label for="adressnumber">Huisnummer met toevoegsel*</label>
<input type="text" name="adressnummer" value="' . ( isset( $_POST['adressnummer']) ? $adressnumber : null ) . '">
</div>

<div>
<label for="postalcode">Postcode*</label>
<input type="text" name="postalcode" value="' . ( isset( $_POST['postalcode']) ? $postalcode : null ) . '">
</div>

<div>
<label for="neigbourhood">Buurt</label>
<input type="text" name="neigbourhood" value="' . ( isset( $_POST['neigbourhood']) ? $neigbourhood : null ) . '">
</div>

<div>
<label for="city">Stad*</label>
<input type="text" name="city" value="' . ( isset( $_POST['city']) ? $city : null ) . '">
</div>

<div>
<label for="housinggroup">Woningbouwcorperatie</label>
<input type="text" name="housinggroup" value="' . ( isset( $_POST['housinggroup']) ? $housinggroup : null ) . '">
</div>

<input type="submit" name="submit" value="Register"/>
</form>';  }

function watf_user_register_validation (
$username, $password, $email, $website, $first_name, $last_name, $street, $adressnumber, $postalcode, $neighbourhood, $city, $housinggroup ) {
  global $reg_errors;
  $reg_errors = new WP_Error;

  if ( empty( $username ) || empty( $password ) || empty( $email) || empty( $street) || empty( $adressnummer) || empty( $postalcode) || empty($city))
  {
    $reg_errors->add('field', 'Required form field is missing');
  }
  if (empty($street)) {
    $reg_errors->add('field', 'Required STRAAT field is missing');
  }
  if (empty($adressnumber)) {
    $reg_errors->add('field', 'Required ADRESSNUMBER field is missing');
  }
  if (empty($postalcode)) {
    $reg_errors->add('field', 'Required POSTALCODE field is missing');
  }
  if (empty($city)) {
    $reg_errors->add('field', 'Required CITY field is missing');
  }
  if ( 4 > strlen( $username ) ) {
    $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
  }
  if ( username_exists( $username ) ) {
    $reg_errors->add('user_name', 'Sorry, that username already exists!');
  }
  if ( ! validate_username( $username ) ) {
    $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
  }
  if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
  }
  if ( !is_email( $email ) ) {
    $reg_errors->add( 'email_invalid', 'Email is not valid' );
  }
  if ( email_exists( $email ) ) {
    $reg_errors->add( 'email', 'Email Already in use' );
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

function watf_user_register_complete() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $street, $adressnummer, $postalcode, $neighbourhood, $city, $housinggroup;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'first_name'    =>   $first_name,
        'last_name'     =>   $last_name,
        );
        $user = wp_insert_user( $userdata );

        global $wpdb;
        $table_profile = $wpdb->prefix . "watf_users";
        $date = time();
        //On success
        if ( ! is_wp_error( $user ) ) {
          $wpdb->query ("INSERT INTO  " . $table_profile . "
          (`user`, `Street`, `AdressNumber`, `PostalCode`, `Neighbourhood`, `City`, `State`, `HousingGroup`, `registered_on`)
            VALUES ('".$user."', '".$street."', '".$adressnumber."', '".$postalcode."', '".$neighbourhood."', '".$city."', '".$state."', '".$housinggroup."', '".$date."');");
            echo "User created : ". $user;
        }
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
    }
}

function watf_user_register_function() {
  if ( isset($_POST['submit'] ) ) {
        watf_user_register_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['street'],
        $_POST['adressnummer'],
        $_POST['postalcode'],
        $_POST['neigbourhood'],
        $_POST['city'],
        $_POST['state'],
        $_POST['housinggroup']
        );

//$username, $password, $email, $website, $first_name, $last_name, $street, $adressnummer, $postalcode, $neighbourhood, $city, $housinggroup;

        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $street, $adressnummer, $postalcode, $neighbourhood, $city, $housinggroup;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $street     =   sanitize_text_field( $_POST['street'] );
        $adressnumber = sanitize_text_field( $_POST['adressnumber']);
        $postalcode =   $_POST['postalcode'];
        $neighbourhood = sanitize_text_field( $_POST['neighbourhood']);
        $city      =    $_POST['city'];
        $housinggroup = sanitize_text_field( $_POST['housinggroup']);


        // call @function complete_registration to create the user
        // only when no WP_error is found
        watf_user_register_complete(
        $username, $password, $email, $website, $first_name, $last_name, $street, $adressnummer, $postalcode, $neighbourhood, $city, $housinggroup
        );
    }

      watf_user_register_form();
}

// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'watf_register', 'watf_user_register_shortcode' );

// The callback function that will replace [book]
function watf_user_register_shortcode() {
    ob_start();
    watf_user_register_function();
    return ob_get_clean();
}
?>
