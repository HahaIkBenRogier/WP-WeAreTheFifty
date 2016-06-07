<?php
function watf_weight_graph_html() {

    global $wpdb;
    $table_weight = $wpdb->prefix . "watf_weight";
    global $reg_errors;
    $date = time();
    $user = get_current_user_id();
    $result_personal = $wpdb->get_results ("SELECT * FROM ".$table_weight." WHERE `user` = ".$user);

    foreach($result_personal as $object){
        echo $object->id."\n";
        echo $object->date."\n";
        echo $object->user."\n";
        echo $object->weight."\n";
    }
    print_r($result_personal);

    echo    '<canvas id="myChart" width="400" height="300"></canvas>';
    echo    '<script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ["Totaal gemiddelde", "Dit jaar", "Vorige maand", "Deze maand", "Vorig jaar", "Deze week"],
                        datasets: [
                            {
                                label: "Amstel 115",
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
                            } /**,
                             {
                                label: "De Horden",
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
                            },
                            {
                                label: "Wijk bij Duurstede",
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
                            },
                            {
                                label: "Provincie Utrecht",
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
                            },
                            {
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
                            } **/
                        ]
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
