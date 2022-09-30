<?php 
if ($admin==0) {
    $bar_chart_title = "Infant Vaccinations Chart";
    // total patients 
    $select_total_patients = "SELECT COUNT(u.user_id) c 
    FROM users u, patient_details pd, barangays b 
    WHERE role=-1 AND u.user_id=pd.user_id 
        AND b.barangay_id=pd.barangay_id AND b.assigned_midwife=$session_id";
    // echo $select_total_patients;
    if($result_total_patients = mysqli_query($conn, $select_total_patients))  {
        foreach($result_total_patients as $row)  { 
            $total_patients = $row['c'];   
        } 
        mysqli_free_result($result_total_patients); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   
    // appointments today 
    $select_appointments_today = "SELECT COUNT(a.appointment_id) c 
    FROM users u, patient_details pd, barangays b, appointments a 
    WHERE role=-1 AND u.user_id=pd.user_id AND a.patient_id=u.user_id AND (a.date BETWEEN '$curr_date 00:00:00' AND '$curr_date 23:59:59')
        AND b.barangay_id=pd.barangay_id AND b.assigned_midwife=$session_id AND a.status=1";
    // echo $select_appointments_today;
    if($result_appointments_today = mysqli_query($conn, $select_appointments_today))  {
        foreach($result_appointments_today as $row)  { 
            $appointments_today = $row['c'];   
        } 
        mysqli_free_result($result_appointments_today); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   
    // tetanus vaccinated
    $select_total_vacc = "SELECT COUNT(u.user_id) c 
    FROM users u, patient_details pd, barangays b 
    WHERE role=-1 AND u.user_id=pd.user_id AND pd.tetanus=1
        AND b.barangay_id=pd.barangay_id AND b.assigned_midwife=$session_id";
    // echo $select_total_vacc;
    if($result_total_vacc = mysqli_query($conn, $select_total_vacc))  {
        foreach($result_total_vacc as $row)  { 
            $total_vacc = $row['c'];   
        } 
        mysqli_free_result($result_total_vacc); 
    } 
    else  { 
        $error = 'Something went wrong fetching data from the database.'; 
    }   
    //TODO: change to infant vacc records 
    // get infant vaccination records 
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
    $labels = '["Months ('.$curr_year.')", "Measles", "Polio", "Penta", "Pneumococcal"],';
   

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
Midwife <br/>
    <!-- <div class="row mt-5 col-sm-12">
        
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="piechart" class="chart"
                style="bottom:200px; width: 400px;height 200px;"> </div>
        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center">
            <div id="columnchart_material" class="columnchart"> </div>
        </div>
    </div>   --> 
    <div> 
        <div>  
            Total Number of Patients: <?php echo $total_patients ?>  
        </div>
        <div>  
            Appointments Today: <?php echo $appointments_today ?>  
        </div>
        <div>  
            Tetanus Toxoid Vaccinated Patients: <?php echo $total_vacc ?>  
        </div> 
    </div>
    <?php include_once('barchart.php');?>
</div>

<!-- <div class="container">
    <div class="row bg-light m-3 con1"></div>
</div> -->

<?php 
}
?>