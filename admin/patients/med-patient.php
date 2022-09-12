<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';

$session_id = $_SESSION['id'];
$id_from_get = $_GET['id'];
if ($session_id==$id_from_get) {
  $redirect_condition = "not-for-nurse";
} else {
  $redirect_condition = "midwife-only";
}

@include "../php-templates/redirect/$redirect_condition.php";


// fetch patient
$select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, 
  u.email,  
  IF(m.tetanus=0, 'Unvaccinated', 'Vaccinated') AS tetanus, d.contact_no, d.b_date,  health_center,
  CONCAT(height_ft, '\'', height_in, '\"') as height, weight, blood_type, diagnosed_condition, allergies,
  details_id, med_history_id
  FROM users as u, details as d, barangay as b, med_history as m
  WHERE u.id=$id_from_get AND d.id=u.details_id AND d.barangay_id=b.id AND m.id=d.med_history_id";
// echo $select;
$result = mysqli_query($conn, $select);
if(mysqli_num_rows($result) > 0)  {
  foreach($result as $row)  {
    $id = $row['id'];  
    $name = $row['name'];  
    $e = $row['email'];  
    $s = $row['tetanus']; 
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
$yester_date = date("Y-m-d H:i:s", strtotime('-1 day'));
// fetch patient appointments 
$select2_a = "SELECT a.date a_date
  FROM appointment a
  WHERE $id_from_get=a.patient_id AND a.date>='$yester_date' AND a.status=1 
  ORDER BY a.date DESC LIMIT 1";

// echo $select2; 
if($result2_a = mysqli_query($conn, $select2_a))  {
  foreach($result2_a as $row)  {
    $a_date = $row['a_date'];  
  } 
  mysqli_free_result($result2_a);
} 
else  { 
  mysqli_free_result($result2_a);
  $error = 'Something went wrong fetching data from the database.'; 
}  


// fetch patient treatment records

$select2_t = "SELECT tmr.date t_date, name t_type, description t_description
  FROM treat_med_record tmr,  treat_med tm
  WHERE $id_from_get=tmr.patient_id AND tmr.treat_med_id=tm.id AND category=1
  ORDER BY t_date DESC LIMIT 1";

// echo $select2; 
if($result2_t = mysqli_query($conn, $select2_t))  {
  foreach($result2_t as $row)  {
    $t_type = $row['t_type'];   
    $t_description = $row['t_description'];   
    $t_date = $row['t_date'];    
  } 
  mysqli_free_result($result2_t);
} 
else  { 
  mysqli_free_result($result2_t);
  $error = 'Something went wrong fetching data from the database.'; 
}  

// fetch patient prescription records

$select2_m = "SELECT tmr.date m_date, name m_name, description m_description
  FROM treat_med_record tmr, treat_med tm
  WHERE $id_from_get=tmr.patient_id AND tmr.treat_med_id=tm.id AND category=0
  ORDER BY m_date DESC LIMIT 1";

// echo $select2; 
if($result2_m = mysqli_query($conn, $select2_m))  {
  foreach($result2_m as $row)  {  
    $m_name = $row['m_name'];   
    $m_description = $row['m_description'];   
    $m_date = $row['m_date'];    
  } 
  mysqli_free_result($result2_m);
} 
else  { 
  mysqli_free_result($result2_m);
  $error = 'Something went wrong fetching data from the database.'; 
}  

$conn->close(); 

$page = 'med_patient';
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
        <div class="row bg-light m-3"><h3>View Patient Report</h3>

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
              <td  class="col-md-3 fw-bold">Tetanus Toxoid</td>
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
         
           <table class="table mt-4 table-striped table-responsive table-lg table-bordered table-hover display">
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
            <?php if (isset($t_date)) {?>
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
            <?php if (isset($m_date)) {?>
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
          </table> 
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