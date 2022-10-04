<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

// $vaccine_list = [];
$infant_list = [];
$title = ''; // pie chart title
$curr_date = date("Y-m-d");
$curr_year = substr($curr_date,0,4);
// echo "curr yewar: $curr_year";

$session_id = $_SESSION['id'];

if ($admin==1) {
  // $title = "Patient Vaccine Monitoring Pie Chart"; 
  // get last 6 months of appointments 
  $bar_chart_data_multi_d_arr = array();
 
  // echo $past_6_months; 
} 
if ($admin==0) {
  // $title = "Infant Vaccine Monitoring Pie Chart";
  // $av_vaccine = 0;
  // $used_vaccine = 0;
  // $exp_vaccine = 0;
  // $up_vaccine = 0;

  // fetch infants  
  
  // //fetch people vaccinated with tetanus
  // $select2_1 = "SELECT tetanus, COUNT(u.id) as p_count  
  //   FROM users u, details d, barangay b, med_history m  
  //   WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND d.med_history_id=m.id
  //   GROUP BY tetanus"; 
  // // echo $select2_1;
  // if($result2_1 = mysqli_query($conn, $select2_1))  {
  //   $total_patients = 0; 
  //   foreach($result2_1 as $row)  {
  //     if ($row['tetanus']==1) {
  //       $total_vacc = $row['p_count'];
  //     }
  //     $total_patients += $row['p_count'];  
  //   } 
  //   mysqli_free_result($result2_1);
  //   // print_r($nurse_list); 
  // } 
  // else  { 
  //   mysqli_free_result($result2_1);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  

  // fetch appointments today 

  // $select2_2 = "SELECT COUNT(u.id) as a_count  
  //   FROM users u, barangay b, appointment a, details d
  //   WHERE u.details_id=d.id AND b.assigned_midwife=$session_id AND d.barangay_id=b.id AND A.patient_id=u.id
  //     AND date BETWEEN '$curr_date 00:00:00' AND '$curr_date 23:59:59'"; 
   
  // echo $select2_2;
  // if($result2_2 = mysqli_query($conn, $select2_2))  {
  //   foreach($result2_2 as $row)  { 
  //     $appointments_today = $row['a_count'];  
  //   } 
  //   mysqli_free_result($result2_2);
  //   // print_r($nurse_list);
  
  // } 
  // else  { 
  //   mysqli_free_result($result2_2);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  

  // fetch infant vaccines 
  // $select2_3 = "SELECT *  
  //   FROM vaccine WHERE type=0";   

  // if($result2_3 = mysqli_query($conn, $select2_3))  {
  //   foreach($result2_3 as $row)  { 
  //     $id = $row['id'];  
  //     $batch = $row['batch'];  
  //     $count = $row['count'];  
  //     $used_count = $row['used_count'];  
  //     $status = $row['status'];  
  //     $expiration = $row['expiration'];   
  //     array_push($vaccine_list, array(
  //       'id' => $id,
  //       'batch' => $batch,  
  //       'count' => $count,  
  //       'used_count' => $used_count,  
  //       'status' => $status,  
  //       'expired' => "$curr_date 00:00:00">=$expiration?1:0,   
  //       'expiration' => $expiration
  //     ));
  //   } 
  //   // segregate vaccine count 
  //   foreach ($vaccine_list as $key => $value) {
  //     $count = $value['count'];
  //     if ($value['status']) {
  //       $used_count = $value['used_count'];

  //       $used_vaccine += $used_count;

  //       $unused_count = $count-$used_count;
  //       if ($value['expired'])  
  //         $exp_vaccine += $unused_count;
  //       else  
  //         $av_vaccine += $unused_count;   
  //     } 
  //     else  
  //       $up_vaccine += $count; 
  //   } 
  //   mysqli_free_result($result2_3); 
  // } 
  // else  { 
  //   mysqli_free_result($result2_3);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  
}
// patient 
if ($admin==-1) {

  $select3 = "SELECT height_ft, height_in, weight
    FROM users u, user_details d, patient_details m
    WHERE u.user_id=$session_id AND u.user_id=d.user_id AND u.user_id=m.user_id" ;
  

  if($result3 = mysqli_query($conn, $select3))  {
    foreach($result3 as $row)  {
      $height_ft = $row['height_ft'];  
      $height_in = $row['height_in'];  
      $weight = $row['weight'];   
    } 
    mysqli_free_result($result3);
    // print_r($nurse_list);
    $in_to_m_conversion = 0.0254;
    $ft_to_in_conversion = 12;
    $m = ($height_ft * $ft_to_in_conversion + $height_in) * $in_to_m_conversion; 
    // echo $m. "<br>";
    // echo $height_ft. "<br>";
    // echo $height_in. "<br>";
    // https://www.diabetes.ca/managing-my-diabetes/tools---resources/body-mass-index-(bmi)-calculator#:~:text=Body%20Mass%20Index%20is%20a,most%20adults%2018%2D65%20years.
    // BMI = kg/m2
    $bmi = $weight/$m**2;
    // https://www.nhlbi.nih.gov/health/educational/lose_wt/BMI/bmicalc.htm
    // Underweight = <18.5
    // Normal weight = 18.5–24.9
    // Overweight = 25–29.9
    // Obesity = BMI of 30 or greater
    if ($bmi<=18.5) {
      $bmi_desc = 'Underweight';
    } else if ($bmi<=24.9 && $bmi>18.5) {
      $bmi_desc = 'Normal weight';
    } else if ($bmi<30 && $bmi>24.9) {
      $bmi_desc = 'Overweight';
    } else if ($bmi>=30) {
      $bmi_desc = 'Obese';
    }

  } 
  else  { 
    mysqli_free_result($result3);
    $error = 'Something went wrong fetching data from the database.'; 
  }  
}
else {
  $session_id_sql = $admin==1?"":"AND b.assigned_midwife=$session_id";
  $select2 = "SELECT main.infant_id, infant_name, c_vaccinations, main.user_id
  FROM (SELECT i.infant_id, CONCAT(i.first_name, 
        IF(i.middle_name IS NULL OR i.middle_name='', '', 
            CONCAT(' ', SUBSTRING(i.middle_name, 1, 1), '.')), 
        ' ', i.last_name) infant_name, i.user_id
      FROM infants i, patient_details ud, barangays b WHERE i.user_id=ud.user_id AND ud.barangay_id=b.barangay_id $session_id_sql) main
         LEFT JOIN 
      (SELECT infant_id, COUNT(infant_id) c_vaccinations FROM infant_vac_records GROUP BY infant_id) c
        USING (infant_id)"; 
  
// echo $select2;
  if($result2 = mysqli_query($conn, $select2))  {
    foreach($result2 as $row)  {
      $id = $row['infant_id'];  
      $name = $row['infant_name'];  
      $c_vaccinations = $row['c_vaccinations'];   
      array_push($infant_list, array(
        'id' => $id,
        'name' => $name, 
        'status' => ($c_vaccinations==4
          ?'Completed':'Uncompleted')));
    } 
    mysqli_free_result($result2);
    // print_r($nurse_list);
  
  } 
  else  { 
    $error = 'Something went wrong fetching data from the database.'; 
  }   

  // chart data 
  $past_6_months = date("Y-m-d", strtotime('-5 months'));
  $bar_chart_month_list = [];
  $bar_chart_month_list_label = [];
  for ($i=5; $i > -1; $i--) { 
      $str_to_time = strtotime("-$i months");
      array_push($bar_chart_month_list, date("Y-m",  $str_to_time));
      array_push($bar_chart_month_list_label,  date("M", $str_to_time));
  }
  $bar_chart_data = [];
}




$page = 'dashbaord';
include_once('../php-templates/admin-navigation-head.php');

if ($admin!=-1) {
?>

<?php } ?> 

<div class="d-flex" id="wrapper">
  <!-- Sidebar --> 
  <?php include_once('../php-templates/admin-navigation-left.php'); ?>
  <!-- /#sidebar-wrapper --> 
  <!-- Page Content -->
  <div id="page-content-wrapper" > 
    <?php include_once('../php-templates/admin-navigation-right.php');  
   
      if (isset($error)) {
        echo '<span class="">'.$error.'</span>'; 
      }  
      include_once('../php-templates/dashboard/nurse.php'); 
      include_once('../php-templates/dashboard/midwife.php');
      //include_once('../php-templates/dashboard/patient.php');
      if ($admin==-1) { // patient
    ?> 
      Patient <br/>
      BMI: <?php echo round($bmi,2). " ($bmi_desc)"?>  
    <?php 
      }
      if ($admin!=-1) {
    ?> 
    <div class="px-5" style="margin-bottom:20vh;">
      <table class="table mt-5 table-striped table-responsive table-lg table-bordered table-hover display" id="datatables">
          <thead class="table-dark">
              <tr>
              <th scope="col">#</th>
              <th scope="col">Infant Birth Names</th>
              <th scope="col">Vaccination Status</th>
              <?php if ($admin==0) { ?> 
                  <th scope="col">Action</th>
              <?php } ?> 
              </tr>
          </thead>
          <tbody>

          <?php if (count($infant_list)==0) { ?> 
              <tr> 
                  <td colspan='4' style="text-align:center">No Infant Records</td> 
              </tr> 
          <?php } else 
              foreach ($infant_list as $key => $value) { ?> 
              <tr>
                  <th scope="row"><?php echo ($key+1);?></th>
                  <td><?php echo $value['name'];?></td>
                  <td><?php echo $value['status'];?></td>
                  <?php if ($admin==0) { ?> 
                      <td>
                          <a href="edit-infant.php?id=<?php echo $value['id'] ?>">
                              <button class="edit btn btn-success btn-sm btn-inverse">Edit</button></a>
                          <!-- <a href="delete-infant.php?id=<?php //echo $value['id'] ?>">  -->
                              <!-- <button class="del btn btn-danger btn-sm btn-inverse" onclick="temp_func()">
                              Delete</button>  -->
                          <!-- </a>     -->
                      </td>
                  <?php } ?>  
              </tr> 
          <?php } ?>
              
          </tbody>
      </table>
    </div> 
    <?php } ?>

  </div>  
<!-- /#page-content-wrapper -->
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>