<?php 
if ($admin==1) { 
    // tetanus vaccinated
    $select_total_vacc = "SELECT COUNT(u.user_id) c 
    FROM users u, patient_details pd
    WHERE role=-1 AND u.user_id=pd.user_id AND pd.tetanus=1 AND pd.status=1";
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

    // $bar_chart_title='Consultation Chart'; 
    // // get consultaitons 
    // $consultations_list = [];
    // $select_consultations = "SELECT date, trimester FROM consultations WHERE date>='$past_6_months 00:00:00' ORDER BY date ASC";
    // if($result_consultations = mysqli_query($conn, $select_consultations))  {
    //     foreach($result_consultations as $row)  { 
    //         $date = $row['date'];  
    //         $trimester = $row['trimester'];  
    //         array_push($consultations_list, array(
    //             'date' => substr($date,0,7),
    //             'trimester' => $trimester
    //         ));
    //     } 
    //     mysqli_free_result($result_consultations); 
    // } 
    // else  { 
    //     $error = 'Something went wrong fetching data from the database.'; 
    // }   
    // structure the chart data  
    // $labels = '["Months ('.$curr_year.')", "No Trimester", "1st Trimester", "2nd Trimester", "3rd Trimester"],';

    // $count_consul_list = count($consultations_list)-1;
    // $key_jump = -1;

    // foreach ($bar_chart_month_list as $key1 => $value1) {
    //     $temp_arr = [$bar_chart_month_list_label[$key1]];
    //     $temp0 = 0;
    //     $temp1 = 0;
    //     $temp2 = 0;
    //     $temp3 = 0;
    //     foreach ($consultations_list as $key2 => $value2) {
    //         if ($key_jump>$key2) continue; 

    //         if ($value1==$value2['date']) {
    //             if ($value2['trimester']==0)  {$temp0 += 1;}
    //             if ($value2['trimester']==1)  {$temp1 += 1;}
    //             if ($value2['trimester']==2)  {$temp2 += 1;}
    //             if ($value2['trimester']==3)  {$temp3 += 1;} 
    //             if ($key2==$count_consul_list) {
    //                 $temp_arr = array_merge($temp_arr,[$temp0,$temp1,$temp2,$temp3]);
    //             }
    //         } else {
    //             $key_jump = $key2;
    //             $temp_arr = array_merge($temp_arr,[$temp0,$temp1,$temp2,$temp3]);
    //             break;
    //         }
    //     }
    //     array_push($bar_chart_data,$temp_arr);
    // }

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
    <div class="graphBox"> 
        <div class="col-md-5 box">
            <h6>Number of Patients per Barangay</h6>
            <canvas id="patients"></canvas>
        </div>
        <div class="col-md-7 box">
            <h6 class="text-center">Number of Infants Vaccinated</h6>
            <canvas id="infant"></canvas>
        </div>
    </div> 
   
    <!-- chart => https://www.chartjs.org/ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
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