<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

// $vaccine_list = [];
$infant_list = [];
$title = ''; // pie chart title
$curr_date = date("Y-m-d");

$session_id = $_SESSION['id'];

if ($admin==1) {
  // $title = "Patient Vaccine Monitoring Pie Chart"; 
  // get last 6 months of appointments 
  $bar_chart_data_multi_d_arr = array();
  $past_6_months = date("Y-m-d", strtotime('-5 months'));
  // echo $past_6_months; 
} 
if ($admin==0) {
  // $title = "Infant Vaccine Monitoring Pie Chart";
  // $av_vaccine = 0;
  // $used_vaccine = 0;
  // $exp_vaccine = 0;
  // $up_vaccine = 0;

  // fetch infants  
  // $select2 = "SELECT ir.id, ir.name, measles, penta, polio, pneumococcal 
  //   FROM infant_record ir, users u, barangay b, details d
  //   WHERE u.details_id=d.id AND d.barangay_id=b.id 
  //     AND ir.patient_id=u.id AND b.assigned_midwife=$session_id"; 
  // $result2 = mysqli_query($conn, $select2);

  // if(mysqli_num_rows($result2))  {
  //   foreach($result2 as $row)  {
  //     $id = $row['id'];  
  //     $name = $row['name'];  
  //     $measles = $row['measles'];  
  //     $penta = $row['penta'];  
  //     $polio = $row['polio'];  
  //     $pneumococcal = $row['pneumococcal'];  
  //     array_push($infant_list, array(
  //       'id' => $id,
  //       'name' => $name, 
  //       'status' => (($measles && $penta && $polio && $pneumococcal)
  //         ?'Completed':'Uncomplete')));
  //   } 
  //   mysqli_free_result($result2);
  //   // print_r($nurse_list);
  
  // } 
  // else  { 
  //   mysqli_free_result($result2);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }   
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

  // $select3 = "SELECT height_ft, height_in, weight
  //   FROM users u, details d, med_history m
  //   WHERE u.id=$session_id AND u.details_id=d.id AND d.med_history_id=m.id" ;
  // $result3 = mysqli_query($conn, $select3);

  // if(mysqli_num_rows($result3))  {
  //   foreach($result3 as $row)  {
  //     $height_ft = $row['height_ft'];  
  //     $height_in = $row['height_in'];  
  //     $weight = $row['weight'];   
  //   } 
  //   mysqli_free_result($result3);
  //   // print_r($nurse_list);
  //   $in_to_m_conversion = 0.0254;
  //   $ft_to_in_conversion = 12;
  //   $m = ($height_ft * $ft_to_in_conversion + $height_in) * $in_to_m_conversion; 
  //   // echo $m. "<br>";
  //   // echo $height_ft. "<br>";
  //   // echo $height_in. "<br>";
  //   // https://www.diabetes.ca/managing-my-diabetes/tools---resources/body-mass-index-(bmi)-calculator#:~:text=Body%20Mass%20Index%20is%20a,most%20adults%2018%2D65%20years.
  //   // BMI = kg/m2
  //   $bmi = $weight/$m**2;
  //   // https://www.nhlbi.nih.gov/health/educational/lose_wt/BMI/bmicalc.htm
  //   // Underweight = <18.5
  //   // Normal weight = 18.5–24.9
  //   // Overweight = 25–29.9
  //   // Obesity = BMI of 30 or greater
  //   if ($bmi<=18.5) {
  //     $bmi_desc = 'Underweight';
  //   } else if ($bmi<=24.9 && $bmi>18.5) {
  //     $bmi_desc = 'Normal weight';
  //   } else if ($bmi<30 && $bmi>24.9) {
  //     $bmi_desc = 'Overweight';
  //   } else if ($bmi>=30) {
  //     $bmi_desc = 'Obese';
  //   }

  // } 
  // else  { 
  //   mysqli_free_result($result3);
  //   $error = 'Something went wrong fetching data from the database.'; 
  // }  
}


$conn->close(); 

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
  <div id="page-content-wrapper"> 
    <?php include_once('../php-templates/admin-navigation-right.php');  
    ?> 
      
    <?php   
      include_once('../php-templates/dashboard/nurse.php'); 
      include_once('../php-templates/dashboard/midwife.php');
      //include_once('../php-templates/dashboard/patient.php');
      if ($admin==-1) { // patient
    ?> 
      Patient <br/>
      BMI: <?php //echo round($bmi,2). " ($bmi_desc)"?>  
    <?php 
      }
    ?> 

    

  </div>  
<!-- /#page-content-wrapper -->
</div>

<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>