<?php 
function days_diff($datetime1, $datetime2) {
    return date_diff(
        date_create($datetime1), date_create($datetime2)
    )->days;
}  
if (!isset($_GET['consultations'])) {
    $_GET['consultations'] = 'days';
}

if ($admin==1) { //closing bracket at the end of the file 
    $consultation_aggr = "SELECT SUBSTRING(date, 1, 10) date_wo_time, 
        count(consultation_id) c FROM `consultations` 
    GROUP BY date_wo_time
    HAVING date_wo_time";
    // echo $select_initial_consultations_data;
    $initial_consultations_data = [];
    $str_range = "";
    // print_r($initial_consultations_data);

    if (isset($_POST['custom_range_consultations'])) {
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $_POST['custom_range_consultations'] = null;

        $select_initial_consultations_data = "$consultation_aggr
            BETWEEN '$date_from' AND '$date_to';";
        $days = days_diff($date_from, $date_to);  
        for ($d_i = $days; $d_i >= 0; $d_i--) { 
            $date_to_push = date("Y-m-d", strtotime("-$d_i days"));
            $initial_consultations_data["$date_to_push"] = 0;
        }
        
        if($result_initial_consultations_data = mysqli_query($conn, 
          $select_initial_consultations_data))  {
            foreach($result_initial_consultations_data as $row) 
                $initial_consultations_data[$row['date_wo_time']] = $row['c'];
            $str_range = "$date_from to $date_to ";
            mysqli_free_result($result_initial_consultations_data); 
        } 
        else  
            $error = 'Something went wrong fetching data from the database.';  
    } else { // initial chart data for custom range consultations  
        $_1mo_ago = date("Y-m-d", strtotime("-1 months"));
        if ($_GET['consultations'] === 'days') { 
            $select_initial_consultations_data = "$consultation_aggr
                BETWEEN '$_1mo_ago' AND '$curr_date';";
            // set data to array 
            $days = days_diff($curr_date, $_1mo_ago); 
            // echo $days;
            for ($d_i = $days; $d_i >= 0; $d_i--) { 
                $date_to_push = date("Y-m-d", strtotime("-$d_i days"));
                $initial_consultations_data["$date_to_push"] = 0;
            }
            
            if($result_initial_consultations_data = mysqli_query($conn, $select_initial_consultations_data))  {
                foreach($result_initial_consultations_data as $row) { 
                    $initial_consultations_data[$row['date_wo_time']] = $row['c'];
                }    
                $str_range = "$_1mo_ago to $curr_date ";
                mysqli_free_result($result_initial_consultations_data); 
            } 
            else  
                $error = 'Something went wrong fetching data from the database.';  
        }  
        
        if ($_GET['consultations'] === 'weeks') {
            $initial_consultations_data = [];
            $w_d = $curr_date;
            $to_d = $curr_date;
            $str_range = "Weekly - $_1mo_ago to $curr_date ";
            for ($d2l = 7; $w_d >= $_1mo_ago; $d2l+=7) { 
                $w_d = date("Y-m-d", strtotime("-$d2l days")); 
                $select_initial_consultations_data = 
                    "SELECT count(cons.date) c FROM (SELECT date FROM `consultations` WHERE date BETWEEN '$w_d' AND '$to_d') cons;";
                if($result_initial_consultations_data = mysqli_query($conn, $select_initial_consultations_data))  {
                    foreach($result_initial_consultations_data as $row) { 
                        $initial_consultations_data[(substr($w_d, 5) . " to " . substr($to_d, 5))] = ($row['c']>0 ? $row['c'] : 0);
                    }     
                    mysqli_free_result($result_initial_consultations_data); 
                } 
                else  
                    $error = 'Something went wrong fetching data from the database.';  
                // echo $select_initial_consultations_data . "<br/>" . $initial_consultations_data[(substr($w_d, 5) ." to " . substr($to_d, 5))] . "<br/>";
                // echo substr($w_d, 5) ." to " . substr($to_d, 5) ."<br/>";
                $d2l2 = $d2l + 1;
                $to_d = date("Y-m-d", strtotime("-$d2l2 days"));
            } 
            // reverse array 
            // print_r($initial_consultations_data);
            $initial_consultations_data = array_reverse($initial_consultations_data);
            // print_r($initial_consultations_data);
        }
        if ($_GET['consultations'] === 'months') {
            $_6mos_ago = date("Y-m-d", strtotime("-6 months"));
            $initial_consultations_data = [];
            $w_d = $curr_date;
            $to_d = $curr_date;
            $str_range = "Monthly - $_6mos_ago to $curr_date ";
            for ($d2l = 1; $w_d >= $_6mos_ago; $d2l++) { 
                $w_d = date("Y-m-d", strtotime("-$d2l months")); 
                $select_initial_consultations_data = 
                    "SELECT count(cons.date) c FROM (SELECT date FROM `consultations` WHERE date BETWEEN '$w_d' AND '$to_d') cons;";
                if($result_initial_consultations_data = mysqli_query($conn, $select_initial_consultations_data))  {
                    foreach($result_initial_consultations_data as $row) { 
                        $initial_consultations_data[(substr($w_d, 5) . " to " . substr($to_d, 5))] = ($row['c']>0 ? $row['c'] : 0);
                    }     
                    mysqli_free_result($result_initial_consultations_data); 
                } 
                else  
                    $error = 'Something went wrong fetching data from the database.';  
                // echo $select_initial_consultations_data . "<br/>" . $initial_consultations_data[(substr($w_d, 5) ." to " . substr($to_d, 5))] . "<br/>";
                // echo substr($w_d, 5) ." to " . substr($to_d, 5) ."<br/>";
                $to_d = date("Y-m-d", strtotime("-1 days", strtotime($w_d)));
            } 
            // reverse array 
            // print_r($initial_consultations_data);
            $initial_consultations_data = array_reverse($initial_consultations_data);
            // print_r($initial_consultations_data);
        }
    }
    // tetanus vaccinated
    $select_total_vacc = "SELECT COUNT(u.user_id) c 
    FROM users u, patient_details pd
    WHERE role=-1 AND u.user_id=pd.user_id AND pd.tetanus=1 AND pd.status=1";
    // echo $select_total_vacc;
    if($result_total_vacc = mysqli_query($conn, $select_total_vacc))  {
        foreach($result_total_vacc as $row)   
            $total_vacc = $row['c'];  
        mysqli_free_result($result_total_vacc); 
    } 
    else  
        $error = 'Something went wrong fetching data from the database.';  
    $past_6_months = date("Y-m-d", strtotime('-5 months'));
    // $bar_chart_title='Consultation Chart'; 
    // // get consultaitons 
    $consultations_list = [];
    $select_consultations = "SELECT date, trimester FROM consultations WHERE date>='$past_6_months 00:00:00' ORDER BY date ASC";
    if($result_consultations = mysqli_query($conn, $select_consultations))  {
        foreach($result_consultations as $row)  { 
            $date = $row['date'];  
            $trimester = $row['trimester'];  
            array_push($consultations_list, array(
                'date' => substr($date,0,7),
                'trimester' => $trimester
            ));
        } 
        mysqli_free_result($result_consultations); 
    } 
    else   
        $error = 'Something went wrong fetching data from the database.';  
    // structure the chart data  

    $count_consul_list = count($consultations_list)-1;
    $key_jump = -1;
    $bar_chart_month_list = [];
    $bar_chart_month_list_label = [];
    $bar_chart_data = [];
    // generate months to chart
    for ($i=5; $i > -1; $i--) { 
        $str_to_time = strtotime("-$i months");
        array_push($bar_chart_month_list, date("Y-m",  $str_to_time));
        array_push($bar_chart_month_list_label,  date("M", $str_to_time));
    }
    foreach ($bar_chart_month_list as $key1 => $value1) {
        $temp_arr = [$bar_chart_month_list_label[$key1]];
        $temp0 = 0;
        $temp1 = 0;
        $temp2 = 0;
        $temp3 = 0;
        foreach ($consultations_list as $key2 => $value2) {
            if ($key_jump>$key2) continue; 

            if ($value1==$value2['date']) {
                if ($value2['trimester']==0)  {$temp0 += 1;}
                if ($value2['trimester']==1)  {$temp1 += 1;}
                if ($value2['trimester']==2)  {$temp2 += 1;}
                if ($value2['trimester']==3)  {$temp3 += 1;} 
                if ($key2==$count_consul_list) {
                    $temp_arr = array_merge($temp_arr,[$temp0,$temp1,$temp2,$temp3]);
                }
            } else {
                $key_jump = $key2;
                $temp_arr = array_merge($temp_arr,[$temp0,$temp1,$temp2,$temp3]);
                break;
            }
        }
        array_push($bar_chart_data,$temp_arr);
    }

    // fetch patients
    $patients_per_barangay = [];
    $total_patient_count = 0;
    $sql_all_patients = "SELECT COUNT(u.user_id) c, b.health_center FROM users u, patient_details p, barangays b WHERE role=-1 AND p.status=1 
    AND u.user_id=p.user_id AND p.barangay_id=b.barangay_id GROUP BY p.barangay_id";
    if($result_all_patients = mysqli_query($conn, $sql_all_patients))  {
        
        foreach($result_all_patients as $row) {
            $c = $row['c'];    
            $total_patient_count += $c;
            $health_center = $row['health_center'];    
            array_push($patients_per_barangay, array('count' => $c, 'barangay' => $health_center));
        }   

        mysqli_free_result($result_all_patients); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   

    // fetch patient count

    // infant vax  
    $infant_vax_records = [];
    $sql_all_records = "SELECT COUNT(ivr.infant_vac_rec_id) c, type FROM infant_vac_records ivr GROUP BY type";
    if($result_all_records = mysqli_query($conn, $sql_all_records))  {
        $BCG = 0;
        $hepatitis_B = 0;
        $pentavalent = 0;
        $oral_polio = 0;

        $inactivated_polio = 0;
        $pnueumococcal_conjugate = 0;
        $measles_mumps_rubelia = 0;

        foreach($result_all_records as $row) {
            $c = $row['c'];    
            if ($row['type']==1)  {$BCG += $c;}
            if ($row['type']==2)  {$hepatitis_B += $c;}
            if ($row['type']==3)  {$pentavalent += $c;}
            if ($row['type']==4)  {$oral_polio += $c;} 

            if ($row['type']==5)  {$inactivated_polio += $c;}
            if ($row['type']==6)  {$pnueumococcal_conjugate += $c;}
            if ($row['type']==7)  {$measles_mumps_rubelia += $c;}
        }   

        $infant_vax_records = array( 
            "BCG" => $BCG,
			"Hepatitis B" => $hepatitis_B,
			"Pentavalent" => $pentavalent,
			"Oral Polio" => $oral_polio,
			"Inactivated Polio" => $inactivated_polio,
			"Pnueumococcal Conjugate" => $pnueumococcal_conjugate,
			"Measles, Mumps, and Rubelia" => $measles_mumps_rubelia,
        );
        mysqli_free_result($result_all_records); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   
    $conn->close(); 
?>

<div class="container-fluid default">
    RHU  
    
      <!-- cards -->
    <div class="cardBoxs">
        <div class="cards">
            <div>
                <div class="number"><?php echo $total_patient_count;?></div>
                <div class="cardsNames">Total Number of Patients</div>
            </div>
            <div class="iconBx">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>
        <div class="cards">
            <div>
                <div class="number"><?php echo $total_vacc ?></div>
                <div class="cardsNames">Tetanus Toxoid Vaccinated</div>
            </div>
            <div class="iconBx">
                <ion-icon name="eyedrop-outline"></ion-icon>
            </div>
        </div>
    </div>

            <!-- Add Charts --> 
    <div class="graphBox1">
        <div class="col-md-5 box">
            <div class="graph">
                <h6>Number of Patients per Barangay</h6>
            
                <canvas id="patients"></canvas>
            </div>
        </div>
    </div>
    <div class="graphBox"> 
         <div class="col-md-7 box">
        <h6 class="text-center">Consultations Chart</h6>
        <canvas height="300" id="trimester"></canvas>
    </div>
    <div class="col-md-7 box">
        <h6 class="text-center">Number of Infants Vaccinated</h6>
        <br>
        <canvas height="300" id="infant"></canvas>
    </div>  

    <!-- Chart of report -->
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
      }
      .chartMenu p {
        padding: 10px;
        font-size: 20px;
      }
      .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      }
    </style>
  <!-- </head>
  <body> -->
    <!-- <div class="chartMenu"></div> -->
    <div style="padding-bottom:200px;">
      <div class="chartBox">
        <canvas id="myChart"></canvas>
        <form method="post" action="#myChart">
            Start : <input type="date" name="date_from" required max="<?php echo $curr_date?>"> 
            End: <input type="date" name="date_to" required max="<?php echo $curr_date?>">
            <button type="submit" name="custom_range_consultations">Filter</button> <br>
            <button type="reset">Reset</button> <br>
        </form>
        <a href="./?consultations=days#myChart"><button type="button">Day</button></a>
        <a href="./?consultations=weeks#myChart"><button type="button">Week</button></a>
        <a href="./?consultations=months#myChart"><button type="button">Month</button></a>
      </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script>

 
    const day = [
        <?php foreach ($initial_consultations_data as $key => $value) { ?>
            {x: '<?php echo $key;?>', y: <?php echo $value;?> },
        <?php } ?> 
    ];
    // const day = [
    //     {x: Date.parse('2021-11-01'), y: 18 },
    //     {x: Date.parse('2021-11-02'), y: 12 },
    //     {x: Date.parse('2021-11-03'), y: 16 },
    //     {x: Date.parse('2021-11-04'), y: 9 },
    //     {x: Date.parse('2021-11-05'), y: 12 },
    //     {x: Date.parse('2021-11-06'), y: 3 },
    //     {x: Date.parse('2021-11-07'), y: 9 },
    // ];

    // const week = [
    //     {x: Date.parse('2021-10-31 00:00:00 GMT+0800'), y: 50 },
    //     {x: Date.parse('2021-11-7 00:00:00 GMT+0800'), y: 70 },
    //     {x: Date.parse('2021-11-14 00:00:00 GMT+0800'), y: 100 },
    //     {x: Date.parse('2021-11-21 00:00:00 GMT+0800'), y: 60 },
    //     {x: Date.parse('2021-11-28 00:00:00 GMT+0800'), y: 30 },
    // ];

    // const month = [
    //     {x: Date.parse('2022-10'), y: 500 },
    //     {x: Date.parse('2022-11'), y: 700 },
    //     {x: Date.parse('2022-12'), y: 500 },
    //     {x: Date.parse('2023-1'), y: 600 },
    //     {x: Date.parse('2023-2'), y: 300 },
    // ];
 
    // setup 
    const data = {
      // labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
 
        label: '<?php echo $str_range;?>Report',
        data: day,
        backgroundColor: ['rgba(255, 26, 104, 0.2)',],
        borderColor: ['rgba(255, 26, 104, 1)',], 
        borderWidth: 1
      }]
    };

    // config 
    const config = {
      type: 'bar',
      data,
      options: {
        scales: {
            // x: {
            //     type: 'time',
            //     time: {
            //         unit: 'day'
            //     }
            // },
          y: {
            beginAtZero: true
          }
        }
      }
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

 
    // function timeFrame(period){
    //     console.log(period.value)
    //     if (period.value == 'day'){
    //         myChart.config.options.scales.x.time.unit = period.value;
    //         myChart.config.data.datasets[0].data = day;
    //     }
    //     // if (period.value == 'week'){
    //     //     myChart.config.options.scales.x.time.unit = period.value;
    //     //     myChart.config.data.datasets[0].data = week;
    //     // }
    //     // if (period.value == 'month'){
    //     //     myChart.config.options.scales.x.time.unit = period.value;
    //     //     myChart.config.data.datasets[0].data = month;
    //     // }
    //     myChart.update();
    // }
    </script>

  <!-- </body> -->
 
    
   
    <!-- chart => https://www.chartjs.org/ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        const labels_trimester = [];
        <?php   
            foreach ($bar_chart_month_list_label as $value) {?> 
                labels_trimester.push("<?php echo $value?>")    
        <?php   
            }?> 
        const data_trimester = [ [], [], [], [] ];
        <?php   
            foreach ($bar_chart_data as $value) {?>  
                data_trimester[0].push("<?php echo $value[1]?>");    
                data_trimester[1].push("<?php echo $value[2]?>");    
                data_trimester[2].push("<?php echo $value[3]?>");   
                data_trimester[3].push("<?php echo $value[4]?>");    
        <?php   
            }?>  
        const labels_patients = [];
        const data_patients = [];
        <?php   
            foreach ($patients_per_barangay as $key => $value) {?> 
                labels_patients.push("<?php echo $value['barangay']?>")   
                data_patients.push("<?php echo $value['count']?>")   
        <?php   
            }?> 
        const labels_infant_records = [];
        const data_infant_records = [];
        <?php   
            foreach ($infant_vax_records as $key => $value) {?> 
                labels_infant_records.push("<?php echo $key?>")   
                data_infant_records.push("<?php echo $value?>")   
        <?php   
            }?> 
    </script>
    <script src="../js/chart.js"></script>
    <!-- chart => https://www.chartjs.org/ -->
</div>
 

<?php 
}
?>