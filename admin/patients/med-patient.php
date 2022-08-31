<?php

@include '../includes/config.php';

session_start();

@include '../php-templates/redirect/admin-page-setter.php';
@include '../php-templates/redirect/not-for-nurse.php';


$id_from_get = $_GET['id'];

// fetch patient
$select = "SELECT u.id AS id, 
  CONCAT(u.first_name,IF(u.mid_initial='', '', CONCAT(' ',u.mid_initial,'.')),' ',u.last_name) AS name, 
  u.email,  
  IF(u.status=0, 'Unvaccinated', 'Vaccinated') AS status, d.contact_no, d.b_date,  health_center,
  height, weight, blood_type, diagnosed_condition, allergies,
  details_id, med_history_id
  FROM users as u, details as d, barangay as b, med_history as m
  WHERE u.id=$id_from_get AND d.id=u.details_id AND d.barangay_id=b.id AND m.id=d.med_history_id";
$result = mysqli_query($conn, $select);
$name = '';
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

// fetch patient appointments
// $select2 = "SELECT date FROM appointment WHERE $id_from_get=appointment.id";
// $result2 = mysqli_query($conn, $select2);
// $appointment_list = [];

// if(mysqli_num_rows($result2) > 0)  {
//   foreach($result2 as $row)  {
//     $date = $row['date'];   
//     array_push($patient_list, array(
//       'appointment_date' => $date 
//     ));
//   } 
//   mysqli_free_result($result2);
// } 
// else  { 
//   mysqli_free_result($result2);
//   $error = 'Something went wrong fetching data from the database.'; 
// }  


$conn->close(); 

$page = 'med_patient';
include_once('../php-templates/admin-navigation-head.php');
?>
 
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <?php include_once('../php-templates/admin-navigation-left.php');  ?>

  <!-- Page Content -->
  <div id="page-content-wrapper" style="background-color: #f0cac4">
    <?php include_once('../php-templates/admin-navigation-right.php'); ?>

    <div class="container">
      <div class="row bg-light m-3">view patient report
        <h2>Patient Profile</h2>
        <?php echo $name ?>
        <h2>Patient Medical History</h2>
        <h2>Appointment Record</h2>
        <h2>Treatment Record</h2>
        <h2>Prescription Record</h2>

      </div>
    </div>
  </div>
</div>
 
<?php 
include_once('../php-templates/admin-navigation-tail.php');
?>