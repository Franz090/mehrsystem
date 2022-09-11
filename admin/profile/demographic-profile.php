<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/patient-only.php';

$session_id = $_SESSION['id'];

// fetch patient
$select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, 
  u.email,  
  IF(u.status=0, 'Inactive', 'Active') AS status, d.contact_no, d.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies,
  details_id, med_history_id
  FROM users as u, details as d, barangay as b, med_history as m
  WHERE u.id=$session_id AND d.id=u.details_id AND d.barangay_id=b.id AND m.id=d.med_history_id";
// echo $select;
$result = mysqli_query($conn, $select);
if(mysqli_num_rows($result) > 0)  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['status'];  
    $c_no = $row['contact_no'];  
    $b_date = $row['b_date'];  
    $bgy = $row['health_center'];  
    $det_id = $row['details_id'];   
    $med_id = $row['med_history_id'];   
    $height = $row['height'];   
    $weight = $row['weight'];   
    $blood_type = $row['blood_type'];   
    $diagnosed_condition = $row['diagnosed_condition'];   
    $allergies = $row['allergies'];    
  } 
  mysqli_free_result($result);
} 
else  { 
  mysqli_free_result($result);
  $error = 'Something went wrong fetching data from the database.'; 
}  

// only the latest appointment - with the linked treatment record and prescription record 
// $yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
// // fetch patient appointments

// $med_select = "SELECT tmr1.id AS mr_id, tmr1.date, tm1.name, tm1.description, tm1.status
// FROM treat_med_record AS tmr1, treat_med AS tm1
// WHERE tm1.category=0 AND tmr1.treat_med_id=tm1.id";

// $select2 = "SELECT a.date AS a_date, tm.name AS t_type, tm.description AS t_description, tmr.date AS t_date, 
//     m.name AS m_name, m.description AS m_description, m.date as m_date
//   FROM appointment AS a, treat_med_record AS tmr, treat_med AS tm, ($med_select) AS m
//   WHERE $session_id=a.patient_id AND a.date>='$yester_date' AND a.treatment_record_id=tmr.id 
//     AND tmr.treat_med_id=tm.id AND a.medicine_record_id=m.mr_id 
//   ORDER BY a.date DESC LIMIT 1";

// echo $select2; 
// if($result2 = mysqli_query($conn, $select2))  {
//   foreach($result2 as $row)  {
//     $a_date = $row['a_date'];   
//     $t_type = $row['t_type'];   
//     $t_description = $row['t_description'];   
//     $t_date = $row['t_date'];   
//     $m_name = $row['m_name'];   
//     $m_description = $row['m_description'];   
//     $m_date = $row['m_date'];    
//   } 
//   mysqli_free_result($result2);
// } 
// else  { 
//   mysqli_free_result($result2);
//   $error = 'Something went wrong fetching data from the database.'; 
// }  
 

$conn->close(); 

$page = 'demo_profile';

include_once('../php-templates/admin-navigation-head.php');

?>
<!-- css -->
<style>
.col-centered{
  float: none;
      margin: 0 auto
}
</style>

<div class="d-flex" id="wrapper"> 
  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?> 
  <!-- Page Content -->
  <div id="page-content-wrapper"> 
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container-fluid">
      <?php
        if(isset($error)) 
            echo '<span class="">'.$error.'</span>'; 
        else {
      ?>   
        <div class="row bg-light m-3"><h3>Demographic Profile</h3> 
          <div class="container default table-responsive">
            <div class="col-md-8 col-lg-12 ">
          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
              <tr>
                  <th scope="col">Patient Profile </th>
              </tr>
            </thead>
            <tbody>
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-3 fw-bold">Patient Name</td>
                <td class="col-md-3"><?php echo $name ?></td>
                <td  class="col-md-3 fw-bold">Patient ID</td>
                <td  class="col-md-3"><?php echo $id ?></td>
              </tr>
        
        
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-3 fw-bold">Barangay</td>
                <td class="col-md-3"><?php echo $bgy ?></td>
                <td  class="col-md-3 fw-bold">Status</td>
                <td  class="col-md-3"><?php echo $s ?></td>
              </tr>
      
        
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-3 fw-bold">Contact Number</td>
                <td  class="col-md-3"><?php echo $c_no ?></td>
                <td  class="col-md-3 fw-bold">Date of Birth</td>
                <td class="col-md-3"><?php  
                  $dtf1 = date_create($b_date); 
                  echo date_format($dtf1,"F d, Y");  
                ?></td>
              </tr>
            </tbody>
          </table> 
        
          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
            <tr>
                <th scope="col">Patient Medical History </th>
            </tr>
            </thead>
            <tbody>
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Height</td>
              <td class="col-md-3"><?php echo $height ?></td>
              <td  class="col-md-3 fw-bold">Diagnosed Condition</td>
              <td class="col-md-3"><?php echo $diagnosed_condition ?></td>
            </tr>
            <tr class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Weight</td>
              <td  class="col-md-3"><?php echo $weight ?></td>
              <td  class="col-md-3 fw-bold">Allergies</td>
              <td  class="col-md-3"><?php echo $allergies ?></td>
            </tr >
            <tr  class="row col-xs-3 col-md-12 col-centered">
              <td  class="col-md-3 fw-bold">Blood Type</td>
              <td class="col-md-3"><?php echo $blood_type ?></td> 
              <tr>
            </tbody>
          </table> 
         
          <!-- <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
          <thead class="table-dark text-center" colspan="3">
            <tr>
              <th scope="col">Appointment Record</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($a_date)) {?> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-6 fw-bold">
                  Appointment Date
                </td>
                <td class="col-md-6">
                  
                  <?php
                    $dtf2 = date_create($a_date); 
                    echo date_format($dtf2,"F d, Y");  
                  ?>  
                </td>
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Appointment Time
                </td>
                <td  class="col-md-6">
                  <?php
                    echo date_format($dtf2,"h:i A");  
                  ?>  
                </td>
            </tr>  
            <?php } else { ?> 
                No Appointment
            <?php } ?>
            </tr>
          </tbody>
          </table> 


          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
          <thead class="table-dark text-center" colspan="3">
            <tr>
                <th scope="col">Treatment Record</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($a_date)) {?>
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Treatment Type
                </td>
                <td  class="col-md-6">
                  <?php echo $t_type; ?>  
                </td>
              </tr> 
              <tr class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-6 fw-bold">
                  Treatment Date
               </td>
                <td  class="col-md-6">
                  <?php
                    $dtf3 = date_create($t_date); 
                    echo date_format($dtf3,"F d, Y");  
                  ?>  
                </td>
              </td> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td class="col-md-6 fw-bold">
                  Treatment Time
                </td>
                <td  class="col-md-6">
                  <?php
                    echo date_format($dtf3,"h:i A");  
                  ?>  
                </td>
              </tr>  
              <?php } else { ?> 
                No Treatment Record
            <?php } ?>
          </tbody>
          </table> 

          <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
            <thead class="table-dark text-center" colspan="3">
              <tr>
                  <th scope="col">Prescription Record</th>
              </tr>
            </thead>
            <tbody>
            <?php if (isset($a_date)) {?>
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Type
                </td>
                <td  class="col-md-6">
                  <?php
                    echo $m_name;  
                  ?>  
                </td>
              </tr> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Date
                </td>
                <td  class="col-md-6">
                  <?php
                    $dtf4 = date_create($m_date); 
                    echo date_format($dtf4,"F d, Y");  
                  ?>  
                </td>
              </tr> 
              <tr  class="row col-xs-3 col-md-12 col-centered">
                <td  class="col-md-6 fw-bold">
                  Prescription Time
                </td>
                <td  class="col-md-6">
                  <?php
                    echo date_format($dtf4,"h:i A");  
                  ?>  
                </td>
              </tr>  
              <?php } else { ?> 
                No Prescription Record
            <?php } ?>
            </tbody>
          </table>  -->
            </div> 
          </div>     
        </div>
      <?php
            }
      ?>   
    </div>
 
  </div>
</div>   <!-- wrapper --> 
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>