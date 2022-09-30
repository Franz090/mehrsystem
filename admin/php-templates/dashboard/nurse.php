<?php 
if ($admin==1) { 
    $bar_chart_title='Consultation Chart';
    // generate months to chart
    for ($i=5; $i > -1; $i--) { 
        $str_to_time = strtotime("-$i months");
        array_push($bar_chart_month_list, date("Y-m",  $str_to_time));
        array_push($bar_chart_month_list_label,  date("M", $str_to_time));
    }
    // get consultaitons 
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
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   

    // structure the chart data  
    $labels = '["Months ('.$curr_year.')", "No Trimester", "1st Trimester", "2nd Trimester", "3rd Trimester"],';

    $count_consul_list = count($consultations_list)-1;
    $key_jump = -1;
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
    $sql_all_patients = "SELECT COUNT(user_id) c FROM users WHERE role=-1";
    if($result_all_patients = mysqli_query($conn, $sql_all_patients))  {
        foreach($result_all_patients as $row)    
            $total_patient_count = $row['c'];    
        mysqli_free_result($result_all_patients); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   
    $conn->close(); 
    //bar chart js code 
    include_once('script.php');
?>

<div class="container-fluid default">
    RHU <br/>
    Total Number of Patients: <?php echo $total_patient_count;?>
    <div class="row mt-5">
        <!-- <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="piechart" class="chart"
                style="bottom:200px;width: 400px;height 200px;">
            </div>
        </div> -->
        <div class="col-md-12 col-sm-12 d-flex justify-content-center p-5" >
            <div id="columnchart_material" class="columnchart" style="min-height:500px; min-width:100%">
            </div>
        </div>
    </div>   
</div>
 

<?php 
}
?>