<?php
function watf_weight_graph_html() {


    global $wpdb;
    $table_weight = $wpdb->prefix . "watf_weight";
    $table_profile = $wpdb->prefix . "watf_users";
    global $reg_errors;
    $date = time();
    $user = get_current_user_id();

    // Persoonlijk profiel
    $now = time();
    $thisweek = time()  - (7 * 24 * 60 * 60);
  /*
    $result_personal_thisweek = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$thisweek." AND ".$now." AND `user` = ".$user);
      $array_personal_thisweek = array();
      foreach ($result_personal_thisweek as $object) {
        $array_personal_thisweek[] = $object->weight;
      }
      $avarage_personal_thisweek = array_sum($array_personal_thisweek) / count($array_personal_thisweek);
      echo $avarage_personal_thisweek;

    $result_personal_all = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `user` = ".$user);
      $array_personal_all = array();
      foreach ($result_personal_all as $object) {
        $array_personal_all[] = $object->weight;
      }
      $average_personal_all = array_sum($array_personal_all) / count($array_personal_all);
      echo $average_personal_all; */

    $result_profile = $wpdb->get_results ("SELECT * FROM ".$table_profile." WHERE `user` = ".$user);
      foreach($result_profile as $object){
          $straat = $object->Street;
          $huisnummer = $object->AdressNumber;
          $wijk = $object->Neighbourhood;
          $stad = $object->City;
          $provincie = $object->State;
          $woningcorperatie = $object->HousingGroup;
      }
      $thuis = $straat." ".$huisnummer;


  /*  // Buurt profiel
    $search_neighbourhood = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `Neighbourhood` = '".$wijk."'");
      $users_neighbourhood = array();
      foreach ($search_neighbourhood as $object) {
        $users_neighbourhood[] = $object->user;
      }
      $string_neighbourhood = rtrim(implode(',', $users_neighbourhood), ',');
    $result_neighbourhood = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` in (".$string_neighbourhood.")");
      //print_r($result_neighbourhood);

    // Stad profiel
    $search_city = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `City` = '".$stad."'");
      $users_city = array();
      foreach ($search_city as $object) {
        $users_city[] = $object->user;
      }
      $string_city = rtrim(implode(',', $users_city), ',');
    $result_city = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` in (".$string_city.")");
      //print_r($result_city);

    // Provincie profiel
      $search_state = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `State` = '".$provincie."'");
        $users_state = array();
        foreach ($search_state as $object) {
          $users_state[] = $object->user;
        }
        $string_state = rtrim(implode(',', $users_state), ',');
      $result_state = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` in (".$string_state.")");
        //print_r($result_state);

      // Woningcorp profiel
      if (!empty($woningcorperatie)) {
        $search_housing = $wpdb->get_results ("SELECT `user` FROM ".$table_housing." WHERE `HousingGroup` = '".$woningcorperatie."'");
          $users_housing = array();
          foreach ($search_housing as $object) {
            $users_housing[] = $object->user;
          }
          $string_housing = rtrim(implode(',', $users_housing), ',');
        $result_housing = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` in (".$string_housing.")");
          //print_r($result_housing);

      }
      // Alle profielen
      $result_all = $wpdb->get_results ("SELECT * FROM ".$table_weight);
      */

      function watf_sqlsearch_all ($what, $where, $when) {
        global $wpdb;
        $table_weight = $wpdb->prefix . "watf_weight";
        $table_profile = $wpdb->prefix . "watf_users";
        global $reg_errors;
        $date = time();
        $user = get_current_user_id();

        $now = time();
        $thisweek = strtotime('this week');
        $lastweek = strtotime('2 weeks ago');
        $thismonth = strtotime('this month');
        $lastmonth = strtotime('2 months ago');
        $thisyear = strtotime('this year');

        if ($what == "personal" && $where == "NULL") {
          $users_string = $user;
        } else {
          $users_search = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `".$what."` = '".$where."'");
          $users_array= array();
          foreach ($users_search as $object) {  $users_array[] = $object->user; }
          $users_string = rtrim(implode(',', $users_array), ',');
        };

        $users_search = $wpdb->get_results ("SELECT `user` FROM ".$table_profile." WHERE `".$what."` = '".$where."'");
          $users_array= array();
          foreach ($users_search as $object) {  $users_array[] = $object->user; }
          $users_string = rtrim(implode(',', $users_array), ',');

          if ($when == "all") {
            $weight_search = $wpdb->get_results ("SELECT `weight` FROM ".$table_weight." WHERE `user` in (".$users_string.")");
          } if ($when == "thisweek") {
            $weight_search = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$thisweek." AND ".$now." AND `user` in (".$users_string.")");
          } if ($when == "lastweek") {
            $weight_search = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$lastweek." AND ".$thisweek." AND `user` in (".$users_string.")");
          } if ($when == "thismonth") {
            $weight_search = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$thismonth." AND ".$now." AND `user` in (".$users_string.")");
          } if ($when == "lastmonth") {
            $weight_search = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$lastmonth." AND ".$thismonth." AND `user` in (".$users_string.")");
          } if ($when == "thisyear") {
            $weight_search = $wpdb->get_results ("SELECT weight FROM ".$table_weight." WHERE `date` BETWEEN ".$thisyear." AND ".$now." AND `user` in (".$users_string.")");
          }
          $weight_array = array();
          foreach ($weight_search as $object) {
            $weight_array[] = $object->weight;
          }

        $weight_average = array_sum($weight_array) / count($weight_array);
        if (empty($weight_average)) {
          $weight_average = 0;
        }

        return $weight_average;
      }

      $time_array = array("thisweek", "lastweek", "thismonth", "lastmonth", "thisyear", "all");
      $Personal_array = array();
      $Neighbourhood_array = array();
      $City_array = array();
      $State_array = array();
      $HousingGroup_array = array();
      $all_array = array();
      foreach ($time_array as $value) {
        $Personal_array[] = watf_sqlsearch_all("personal","NULL",$value);
        $Neighbourhood_array[] = watf_sqlsearch_all("Neighbourhood", $wijk, $value);
        $City_array[] = watf_sqlsearch_all("City", $stad, $value);
        $State_array[] = watf_sqlsearch_all("State", $provincie, $value);
        if (!empty($woningcorperatie)) {
          $HousingGroup_array = watf_sqlsearch_all("HousingGroup", $woningcorperatie, $value);
        }
      }
      $Personal_string = rtrim(implode(',', $Personal_array), ',');
      $Neighbourhood_string = rtrim(implode(',', $Neighbourhood_array), ',');
      $City_string = rtrim(implode(',', $City_array), ',');
      $State_string = rtrim(implode(',', $State_array), ',');
      $HousingGroup_string = rtrim(implode(',', $HousingGroup_array), ',');
      $all_string = rtrim(implode(',', $all_array), ',');





    echo    '<canvas id="myChart" width="400" height="300"></canvas>';
    echo    '<script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Totaal gemiddelde", "Dit jaar", "Vorige maand", "Deze maand", "Vorig jaar", "Deze week"],
                        datasets: [';
echo                       '{
                                label: "'. $thuis .'",
                                borderColor: "rgba(255, 139, 46, 1)",
                                borderCapStyle: "butt",
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: "miter",
                                pointBorderColor: "rgba(255, 139, 46, 1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(255, 139, 46, 1)",
                                pointHoverBorderColor: "rgba(255, 139, 46, 1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: ['.$Personal_string.']
                            },';
    echo                       '{
                                label: "'.$wijk.'",
                                borderColor: "rgba(23, 198, 155, 1)",
                                borderCapStyle: "butt",
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: "miter",
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(23, 198, 155, 1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: ['.$Neighbourhood_string.']
                            },';
    echo                      '{
                                label: "'.$stad.'",
                                borderColor: "rgba(23, 198, 155, 1)",
                                borderCapStyle: "butt",
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: "miter",
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(23, 198, 155, 1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: ['.$City_string.']
                            },';
    echo                        '{
                                label: "Provincie '.$provincie.'",
                                borderColor: "rgba(23, 198, 155, 1)",
                                borderCapStyle: "butt",
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: "miter",
                                pointBorderColor: "rgba(75,192,192,1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(23, 198, 155, 1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: ['.$City_string.']
                            },';
if (!empty($woningcorperatie)) {
  echo                        '{
                              label: "Woningbouwcorperatie '.$woningcorperatie.'",
                              borderColor: "rgba(23, 198, 155, 1)",
                              borderCapStyle: "butt",
                              borderDash: [],
                              borderDashOffset: 0.0,
                              borderJoinStyle: "miter",
                              pointBorderColor: "rgba(75,192,192,1)",
                              pointBackgroundColor: "#fff",
                              pointBorderWidth: 1,
                              pointHoverRadius: 5,
                              pointHoverBackgroundColor: "rgba(23, 198, 155, 1)",
                              pointHoverBorderColor: "rgba(220,220,220,1)",
                              pointHoverBorderWidth: 2,
                              pointRadius: 1,
                              pointHitRadius: 10,
                              data: ['.$HousingGroup_string.']
                          },';
}

    echo                        '{
                                label: "Nederland",
                                borderColor: "rgba(49, 49, 49, 1)",
                                borderCapStyle: "butt",
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: "miter",
                                pointBorderColor: "rgba(49, 49, 49, 1)",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "rgba(49, 49, 49, 1)",
                                pointHoverBorderColor: "rgba(220,220,220,1)",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: ['.$all_string.']
                            }';
  echo                     ']
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            </script>';
};

add_shortcode("watf_personalgraph","watf_weight_graph_shortcode");
function watf_weight_graph_shortcode() {
    ob_start();
    watf_weight_graph_html();
    return ob_get_clean();
};
?>
