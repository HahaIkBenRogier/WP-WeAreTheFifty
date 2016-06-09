<?php

function watf_sqlsearch_all ($what, $where) {
  global $wpdb;
  $table_weight = $wpdb->prefix . "watf_weight";
  $table_profile = $wpdb->prefix . "watf_users";
  global $reg_errors;
  $date = time();
  $user = get_current_user_id();

  $users_search = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `".$what."` = '".$where."'");
    $users_array= array();
    foreach ($users_search as $object) {
      $users_array[] = $object->user;
    }
    $users_string = rtrim(implode(',', $users_array), ',');
  $weight_result = $wpdb->get_results ("SELECT `weight` FROM ".$table_weight." WHERE `user` in (".$users_string.")");
  $weight_average = array_sum($users_array) / count($users_array);

  return $weight_average;
}

?>
