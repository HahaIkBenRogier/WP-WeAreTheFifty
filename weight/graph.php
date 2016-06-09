<?php
function watf_weight_graph_html() {

    global $wpdb;
    $table_weight = $wpdb->prefix . "watf_weight";
    $table_profile = $wpdb->prefix . "watf_users";
    global $reg_errors;
    $date = time();
    $user = get_current_user_id();

    // Persoonlijk profiel
    $result_personal = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` = ".$user);
      print_r($result_personal);
      $array_personal_all = array();
      foreach ($result_personal as $object) {
        $array_personal_all[] = $object->weight;
      }
      $average_personal_all = array_sum($array_personal_all) / count($array_personal_all);
      echo $average_personal_all;
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

    // Buurt profiel
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
                                data: [36, 30, 31.5, 30, 25, 21]
                            } /**,';
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
                                data: [40, 36, 37, 31, 27, 25]
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
                                data: [35, 30, 32, 31, 29, 30]
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
                                data: [10, 25, 3.6, 1, 9, 7]
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
                              data: [10, 25, 3.6, 1, 9, 7]
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
                                data: [12, 19, 3, 5, 2, 3]
                            } **/';
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
